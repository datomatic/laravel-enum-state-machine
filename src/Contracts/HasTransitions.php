<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Contracts;

use Illuminate\Database\Eloquent\Model;
use UnitEnum;

interface HasTransitions
{
    public static function canTransition(?UnitEnum $from, ?UnitEnum $to, Model $model): bool;
}
