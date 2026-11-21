<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Concerns;

use Datomatic\LaravelEnumStateMachine\Support\EnumValue;
use Datomatic\LaravelEnumStateMachine\Support\Transitions;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

/**
 * @mixin Model
 */
trait HasEnumStateMachine
{
    public function canTransitionTo(string $attribute, UnitEnum|int|string|null $to): bool
    {
        $enumClass = Transitions::castFor($this, $attribute)->enumClass;

        return Transitions::allows(
            $this,
            $attribute,
            EnumValue::toEnum($enumClass, $this->getAttributes()[$attribute] ?? null),
            EnumValue::toEnum($enumClass, $to),
        );
    }
}
