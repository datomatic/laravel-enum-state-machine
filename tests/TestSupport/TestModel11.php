<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport;

use Datomatic\LaravelEnumStateMachine\Casts\AsLaravelEnumCollection;
use Datomatic\LaravelEnumStateMachine\EnumCollection;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\IntBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\LaravelEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\PureEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\StringBackedEnum;
use Datomatic\LaravelEnumStateMachine\Traits\HasLaravelEnumStateMachine;
use Illuminate\Database\Eloquent\Model;
use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;

/**
 * @property IntBackedEnum $int_status
 * @property PureEnum $pure_status
 * @property StringBackedEnum $string_status
 * @property LaravelEnum $laravel_status
 * @property array $json
 *
 * basically used just to test the AsLaravelEnumCollection cast with laravel ^11.0 syntax
 */
class TestModel11 extends Model
{

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;

    protected function casts()
    {
        return [
            'int_status' => AsEnumStateMachine::class.':'.IntBackedEnum::class.',true',
            'pure_status' => AsEnumStateMachine::class.':'.PureEnum::class.',1',
            'string_status' => AsEnumStateMachine::class.':'.StringBackedEnum::class.',false',
            'laravel_status' => AsEnumStateMachine::class.':'.LaravelEnum::class,
            'json' => 'array',
        ];

    }
}
