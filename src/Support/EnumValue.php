<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Support;

use BackedEnum;
use ReflectionEnum;
use UnitEnum;
use ValueError;

class EnumValue
{
    /**
     * @template TEnum of UnitEnum
     *
     * @param  class-string<TEnum>  $enumClass
     * @return TEnum|null
     */
    public static function toEnum(string $enumClass, mixed $value): ?UnitEnum
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof $enumClass) {
            return $value;
        }

        if (! is_int($value) && ! is_string($value)) {
            throw new ValueError('Invalid value for enum '.$enumClass.': '.get_debug_type($value).' given.');
        }

        if (is_subclass_of($enumClass, BackedEnum::class)) {
            $backingType = (string) (new ReflectionEnum($enumClass))->getBackingType();

            return $enumClass::from($backingType === 'int' ? (int) $value : (string) $value);
        }

        foreach ($enumClass::cases() as $case) {
            if ($case->name === (string) $value) {
                return $case;
            }
        }

        throw new ValueError("\"{$value}\" is not a valid case for enum {$enumClass}");
    }

    public static function toStorable(?UnitEnum $enum): int|string|null
    {
        if ($enum === null) {
            return null;
        }

        return $enum instanceof BackedEnum ? $enum->value : $enum->name;
    }
}
