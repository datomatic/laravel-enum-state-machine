<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use UnitEnum;

class Transitioning
{
    use Dispatchable;

    public function __construct(
        public Model $model,
        public string $attribute,
        public ?UnitEnum $from,
        public ?UnitEnum $to,
    ) {}
}
