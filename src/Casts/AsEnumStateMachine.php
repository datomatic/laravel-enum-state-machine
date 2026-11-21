<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Casts;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use UnitEnum;

enum AsEnumStateMachine implements Castable
{
    /**
     * @param  array<int, string>  $arguments
     * @return CastsAttributes<UnitEnum|null, UnitEnum|int|string|null>
     */
    public static function castUsing(array $arguments): CastsAttributes
    {
        return EnumStateMachineCast::fromArguments($arguments);
    }

    /**
     * @param  class-string<UnitEnum>  $enumClass
     */
    public static function of(string $enumClass, ?bool $softMode = null): string
    {
        $cast = self::class.':'.$enumClass;

        if ($softMode === null) {
            return $cast;
        }

        return $cast.','.($softMode ? 'true' : 'false');
    }
}
