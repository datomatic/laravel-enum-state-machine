<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Exceptions;

use Exception;

class StatusTransitionDenied extends Exception
{
    public function __construct(string $from, string $to)
    {
        parent::__construct('Unsupported transition from: '.$from.' to: '.$to);
    }
}
