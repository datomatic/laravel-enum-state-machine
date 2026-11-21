<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Support;

use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Casts\EnumStateMachineCast;
use Datomatic\LaravelEnumStateMachine\Contracts\HasTransitions;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use UnitEnum;

class Transitions
{
    /**
     * The model method ({attribute}Transitions) takes precedence over the enum
     * HasTransitions contract, so a model can override the enum rules.
     */
    public static function allows(Model $model, string $attribute, ?UnitEnum $from, ?UnitEnum $to): bool
    {
        if ($from === $to) {
            return true;
        }

        $method = str($attribute)->camel()->append('Transitions')->toString();

        if (method_exists($model, $method)) {
            return (bool) $model->{$method}($from, $to);
        }

        $enum = $from ?? $to;

        if ($enum instanceof HasTransitions) {
            return $enum::canTransition($from, $to, $model);
        }

        return true;
    }

    public static function castFor(Model $model, string $attribute): EnumStateMachineCast
    {
        $cast = $model->getCasts()[$attribute] ?? null;
        $prefix = AsEnumStateMachine::class.':';

        if (! is_string($cast) || ! str_starts_with($cast, $prefix)) {
            throw new InvalidArgumentException("The [{$attribute}] attribute of [".$model::class.'] is not cast with '.AsEnumStateMachine::class.'.');
        }

        return EnumStateMachineCast::fromArguments(explode(',', substr($cast, strlen($prefix))));
    }
}
