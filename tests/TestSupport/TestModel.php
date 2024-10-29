<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport;

use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\IntBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\LaravelEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\PureEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\StringBackedEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @property IntBackedEnum $int_status
 * @property PureEnum $pure_status
 * @property StringBackedEnum $string_status
 * @property LaravelEnum $laravel_status
 * @property array $json
 */
class TestModel extends Model
{
    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'int_status' => AsEnumStateMachine::class.':'.IntBackedEnum::class,
        'pure_status' => AsEnumStateMachine::class.':'.PureEnum::class,
        'string_status' => AsEnumStateMachine::class.':'.StringBackedEnum::class,
        'laravel_status' => AsEnumStateMachine::class.':'.LaravelEnum::class,
        'json' => 'array',
    ];

    public function intStatusTransitions(?IntBackedEnum $from, ?IntBackedEnum $to): bool
    {
        return match ($from) {
            IntBackedEnum::PRIVATE => match ($to) {
                IntBackedEnum::PROTECTED => false,
                IntBackedEnum::PUBLIC => false,
                default => false
            },
            IntBackedEnum::PUBLIC => match ($to) {
                IntBackedEnum::PRIVATE => true,
                IntBackedEnum::PROTECTED => true,
                default => false
            },
            IntBackedEnum::PROTECTED => match ($to) {
                IntBackedEnum::PRIVATE => true,
                IntBackedEnum::PUBLIC => false,
                default => false
            },
            default => true
        };
    }

    public function pureStatusTransitions(?PureEnum $from, ?PureEnum $to): bool
    {
        return match ($from) {
            PureEnum::PRIVATE => match ($to) {
                PureEnum::PROTECTED => false,
                PureEnum::PUBLIC => false,
                default => false
            },
            PureEnum::PUBLIC => match ($to) {
                PureEnum::PRIVATE => true,
                PureEnum::PROTECTED => true,
                default => false
            },
            PureEnum::PROTECTED => match ($to) {
                PureEnum::PRIVATE => true,
                PureEnum::PUBLIC => false,
                default => false
            },
            default => true
        };
    }

    public function stringStatusTransitions(?StringBackedEnum $from, ?StringBackedEnum $to): bool
    {
        return match ($from) {
            StringBackedEnum::PRIVATE => match ($to) {
                StringBackedEnum::PROTECTED => false,
                StringBackedEnum::PUBLIC => false,
                default => false
            },
            StringBackedEnum::PUBLIC => match ($to) {
                StringBackedEnum::PRIVATE => true,
                StringBackedEnum::PROTECTED => true,
                default => false
            },
            StringBackedEnum::PROTECTED => match ($to) {
                StringBackedEnum::PRIVATE => true,
                StringBackedEnum::PUBLIC => false,
                default => false
            },
            default => true
        };
    }

    public function laravelStatusTransitions(?LaravelEnum $from, ?LaravelEnum $to): bool
    {
        return match ($from) {
            LaravelEnum::PRIVATE => match ($to) {
                LaravelEnum::PROTECTED => false,
                LaravelEnum::PUBLIC => false,
                default => false
            },
            LaravelEnum::PUBLIC => match ($to) {
                LaravelEnum::PRIVATE => true,
                LaravelEnum::PROTECTED => true,
                default => false
            },
            LaravelEnum::PROTECTED => match ($to) {
                LaravelEnum::PRIVATE => true,
                LaravelEnum::PUBLIC => false,
                default => false
            },
            default => true
        };
    }
}
