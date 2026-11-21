<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests;

use Datomatic\LaravelEnumStateMachine\LaravelEnumStateMachineServiceProvider;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\LaravelEnum;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelEnumStateMachineServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        config()->set('database.default', 'testing');
    }

    protected function setUpDatabase(): void
    {
        if (! Schema::hasTable('test_models')) {
            Schema::create('test_models', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedSmallInteger('int_status')->nullable();
                $table->string('string_status')->nullable();
                $table->string('pure_status')->nullable();
                $table->enum('laravel_status', LaravelEnum::values())->nullable();
                $table->unsignedSmallInteger('article_status')->nullable();
            });
        }
    }
}
