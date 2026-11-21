<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class StatusTransitionDenied extends Exception
{
    public function __construct(
        public Model $model,
        public string $attribute,
        public ?UnitEnum $from,
        public ?UnitEnum $to,
    ) {
        parent::__construct(sprintf(
            'Transition of [%s] on [%s] from [%s] to [%s] is not allowed.',
            $attribute,
            $model::class,
            $from->name ?? 'null',
            $to->name ?? 'null',
        ));
    }
}
