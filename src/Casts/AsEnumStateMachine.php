<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Casts;

use BackedEnum;
use Datomatic\LaravelEnumStateMachine\Exceptions\StatusTransitionDenied;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use ReflectionEnum;
use UnitEnum;

enum AsEnumStateMachine implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @return CastsAttributes<Stringable, string|\Stringable>
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class($arguments) implements CastsAttributes
        {
            protected $arguments;

            public function __construct(array $arguments)
            {
                $this->arguments = $arguments;
            }

            public function get(Model $model, string $key, mixed $value, array $attributes)
            {
                $enumClass = $this->arguments[0];

                return $this->getEnumFromValue($value, $enumClass);
            }

            public function set(Model $model, string $key, mixed $value, array $attributes)
            {
                /** @var class-string $enumClass */
                $enumClass = $this->arguments[0];
                $softMode = $this->arguments[1] ?? config('enum-state-machine.soft_mode');
                $methodName = Str::camel($key).'Transitions';

                $previousValue = isset($attributes[$key]) ? $this->getEnumFromValue($attributes[$key], $enumClass) : null;
                $newValue = $this->getEnumFromValue($value, $enumClass);

                if ($previousValue === $newValue) {
                    return $value;
                }

                if (method_exists($model, $methodName)) {
                    $can = $model->$methodName($previousValue, $newValue);
                    if (! $can) {
                        if(! $softMode){
                            throw new StatusTransitionDenied($previousValue->name ?? 'null', $newValue->name ?? 'null');
                        }
                        Log::error('Status Transition Denied on '.$model->getTable().' '.$model->id.' from '.($previousValue->name ?? 'null').' to '.($newValue->name ?? 'null'));
                    }
                }

                return $newValue ? $this->getStorableEnumValue($newValue) : null;
            }

            protected function getStorableEnumValue($enum): int|string
            {
                return $enum instanceof BackedEnum ? $enum->value : $enum->name;
            }

            protected function getEnumFromValue(int|string|null|UnitEnum $value, string $enumClass)
            {
                if ($value instanceof UnitEnum) {
                    return $value;
                }

                if ($value === null) {
                    return null;
                }

                if(is_subclass_of($enumClass, BackedEnum::class)){
                    $type = (string) (new ReflectionEnum($enumClass))->getBackingType();

                    if($type === 'int'){
                        $value = (int) $value;
                    }

                    return $enumClass::from($value);
                }

                return constant($enumClass.'::'.$value);
            }
        };
    }

    /**
     * Specify the Enum for the cast.
     *
     * @param  class-string  $class
     * @return string
     */
    public static function of($class, ?bool $softMode = null)
    {
        return self::class.':'.$class.($softMode ? ','.$softMode : '');
    }
}
