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
     * @param  array{class-string,?bool}  $arguments
     * @return CastsAttributes<Stringable, string|\Stringable>
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class($arguments) implements CastsAttributes
        {
            /** @var array{class-string,?bool} */
            protected array $arguments;

            /**
             * @param  array{class-string,?bool}  $arguments
             */
            public function __construct(array $arguments)
            {
                $this->arguments = $arguments;
            }

            public function get(Model $model, string $key, mixed $value, array $attributes)
            {
                /** @var null|string|int|UnitEnum $value */

                /** @var class-string $enumClass */
                $enumClass = $this->arguments[0];

                return $this->getEnumFromValue($value, $enumClass);
            }

            public function set(Model $model, string $key, mixed $value, array $attributes)
            {
                /** @var null|string|int|UnitEnum $value */

                /** @var class-string $enumClass */
                $enumClass = $this->arguments[0];
                $softMode = $this->arguments[1] ?? config('laravel-enum-state-machine.soft_mode');
                $methodName = Str::camel($key).'Transitions';

                /** @var null|string|int|UnitEnum $previousValue */
                $previousValue = $attributes[$key] ?? null;
                $previousEnumValue = $previousValue ? $this->getEnumFromValue($previousValue, $enumClass) : null;
                $newEnumValue = $this->getEnumFromValue($value, $enumClass);

                if ($previousEnumValue === $newEnumValue) {
                    return $value;
                }

                if (method_exists($model, $methodName)) {
                    $can = $model->$methodName($previousEnumValue, $newEnumValue);
                    if (! $can) {
                        if (! $softMode) {
                            throw new StatusTransitionDenied($previousEnumValue->name ?? 'null', $newEnumValue->name ?? 'null');
                        }
                        Log::error('Status Transition Denied on '.$model->getTable().' '.$model->getKey().
                            ' from '.($previousEnumValue->name ?? 'null').' to '.($newEnumValue->name ?? 'null'));
                    }
                }

                return $newEnumValue ? $this->getStorableEnumValue($newEnumValue) : null;
            }

            protected function getStorableEnumValue(UnitEnum $enum): int|string
            {
                return $enum instanceof BackedEnum ? $enum->value : $enum->name;
            }

            protected function getEnumFromValue(int|string|null|UnitEnum $value, string $enumClass): ?UnitEnum
            {
                if ($value instanceof UnitEnum) {
                    return $value;
                }

                if ($value === null) {
                    return null;
                }

                if (is_subclass_of($enumClass, BackedEnum::class)) {
                    $type = (string) (new ReflectionEnum($enumClass))->getBackingType();

                    if ($type === 'int') {
                        $value = (int) $value;
                    }

                    return $enumClass::from($value);
                }
                /** @var UnitEnum $enum */
                $enum = constant($enumClass.'::'.$value);

                return $enum;
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
