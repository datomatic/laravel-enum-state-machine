<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport;

use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\IntBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\LaravelEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\PureEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\StringBackedEnum;

class CastsMethodModel extends TestModel
{
    protected $casts = [];

    protected function casts(): array
    {
        return [
            'int_status' => AsEnumStateMachine::class.':'.IntBackedEnum::class.',true',
            'pure_status' => AsEnumStateMachine::class.':'.PureEnum::class.',1',
            'string_status' => AsEnumStateMachine::class.':'.StringBackedEnum::class.',false',
            'laravel_status' => AsEnumStateMachine::of(LaravelEnum::class, false),
        ];
    }
}
