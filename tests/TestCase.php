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

    protected function getPackageProviders($app)
    {
        return [
            LaravelEnumStateMachineServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-enum-state-machine_table.php.stub';
        $migration->up();
        */
    }

    protected function setUpDatabase()
    {
        if (! Schema::hasTable('test_models')) {
            Schema::create('test_models', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedSmallInteger('int_status')->nullable();
                $table->string('string_status')->nullable();
                $table->string('pure_status')->nullable();
                $table->enum('laravel_status', LaravelEnum::values())->nullable();
                $table->json('json')->nullable();
            });
        }
    }
}
