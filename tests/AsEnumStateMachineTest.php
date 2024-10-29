<?php

declare(strict_types=1);

use Datomatic\LaravelEnumStateMachine\Exceptions\StatusTransitionDenied;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\IntBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\LaravelEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\PureEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\StringBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\TestModel;

beforeEach(function () {
    $this->testModel = new TestModel;
});

test('transition not permitted on pure enum', function (?UnitEnum $from, ?UnitEnum $to) {
    $this->testModel->pure_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->pure_status = $to)->toThrow(StatusTransitionDenied::class);

})->with([
    'int enum public => null' => [PureEnum::PUBLIC, null],
    'int enum protected => public' => [PureEnum::PROTECTED, PureEnum::PUBLIC],
    'int enum protected => null' => [PureEnum::PROTECTED, null],
    'int enum private => public' => [PureEnum::PRIVATE, PureEnum::PUBLIC],
    'int enum private => protected' => [PureEnum::PRIVATE, PureEnum::PROTECTED],
    'int enum private => null' => [PureEnum::PRIVATE, null],
]);

test('transition permitted on pure enum', function (?UnitEnum $from, ?UnitEnum $to) {
    $this->testModel->pure_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->pure_status = $to)->not->toThrow(StatusTransitionDenied::class);
    if ($to instanceof UnitEnum) {
        expect($model->pure_status)->toBe($to);
    }

})->with([
    'int enum null => null' => [null, null],
    'int enum null => public' => [null, PureEnum::PUBLIC],
    'int enum null => protected' => [null, PureEnum::PROTECTED],
    'int enum null => private' => [null, PureEnum::PRIVATE],
    'int enum public => public' => [PureEnum::PUBLIC, PureEnum::PUBLIC],
    'int enum public => protected' => [PureEnum::PUBLIC, PureEnum::PROTECTED],
    'int enum public => private' => [PureEnum::PUBLIC, PureEnum::PRIVATE],
    'int enum protected => protected' => [PureEnum::PROTECTED, PureEnum::PROTECTED],
    'int enum protected => private' => [PureEnum::PROTECTED, PureEnum::PRIVATE],
    'int enum private => private' => [PureEnum::PRIVATE, PureEnum::PRIVATE],
]);

test('transition not permitted on int backed enum', function (?UnitEnum $from, null|int|UnitEnum $to) {
    $this->testModel->int_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->int_status = $to)->toThrow(StatusTransitionDenied::class);

})->with([
    'int enum public => null' => [IntBackedEnum::PUBLIC, null],
    'int enum protected => public' => [IntBackedEnum::PROTECTED, IntBackedEnum::PUBLIC],
    'int enum protected => 2' => [IntBackedEnum::PROTECTED, 2],
    'int enum protected => null' => [IntBackedEnum::PROTECTED, null],
    'int enum private => public' => [IntBackedEnum::PRIVATE, IntBackedEnum::PUBLIC],
    'int enum private => 2' => [IntBackedEnum::PRIVATE, 2],
    'int enum private => protected' => [IntBackedEnum::PRIVATE, IntBackedEnum::PROTECTED],
    'int enum private => 3' => [IntBackedEnum::PRIVATE, 3],
    'int enum private => null' => [IntBackedEnum::PRIVATE, null],
]);

test('transition permitted on int backed enum', function (?UnitEnum $from, null|int|UnitEnum $to) {
    $this->testModel->int_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->int_status = $to)->not->toThrow(StatusTransitionDenied::class);
    if ($to instanceof UnitEnum) {
        expect($model->int_status)->toBe($to);
    }

})->with([
    'int enum null => null' => [null, null],
    'int enum null => public' => [null, IntBackedEnum::PUBLIC],
    'int enum null => 2' => [null, 2],
    'int enum null => protected' => [null, IntBackedEnum::PROTECTED],
    'int enum null => 3' => [null, 3],
    'int enum null => private' => [null, IntBackedEnum::PRIVATE],
    'int enum null => 1' => [null, 1],
    'int enum public => public' => [IntBackedEnum::PUBLIC, IntBackedEnum::PUBLIC],
    'int enum public => protected' => [IntBackedEnum::PUBLIC, IntBackedEnum::PROTECTED],
    'int enum public => private' => [IntBackedEnum::PUBLIC, IntBackedEnum::PRIVATE],
    'int enum protected => protected' => [IntBackedEnum::PROTECTED, IntBackedEnum::PROTECTED],
    'int enum protected => private' => [IntBackedEnum::PROTECTED, IntBackedEnum::PRIVATE],
    'int enum private => private' => [IntBackedEnum::PRIVATE, IntBackedEnum::PRIVATE],
]);

test('transition not permitted on string backed enum', function (?UnitEnum $from, null|string|UnitEnum $to) {
    $this->testModel->string_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->string_status = $to)->toThrow(StatusTransitionDenied::class);

})->with([
    'int enum public => null' => [StringBackedEnum::PUBLIC, null],
    'int enum protected => public' => [StringBackedEnum::PROTECTED, StringBackedEnum::PUBLIC],
    'int enum protected => V' => [StringBackedEnum::PROTECTED, 'V'],
    'int enum protected => null' => [StringBackedEnum::PROTECTED, null],
    'int enum private => public' => [StringBackedEnum::PRIVATE, StringBackedEnum::PUBLIC],
    'int enum private => V' => [StringBackedEnum::PRIVATE, 'V'],
    'int enum private => protected' => [StringBackedEnum::PRIVATE, StringBackedEnum::PROTECTED],
    'int enum private => -' => [StringBackedEnum::PRIVATE, '-'],
    'int enum private => null' => [StringBackedEnum::PRIVATE, null],
]);

test('transition permitted on string backed enum', function (?UnitEnum $from, null|string|UnitEnum $to) {
    $this->testModel->string_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->string_status = $to)->not->toThrow(StatusTransitionDenied::class);
    if ($to instanceof UnitEnum) {
        expect($model->string_status)->toBe($to);
    }

})->with([
    'int enum null => null' => [null, null],
    'int enum null => public' => [null, StringBackedEnum::PUBLIC],
    'int enum null => V' => [null, 'V'],
    'int enum null => protected' => [null, StringBackedEnum::PROTECTED],
    'int enum null => -' => [null, '-'],
    'int enum null => private' => [null, StringBackedEnum::PRIVATE],
    'int enum null => X' => [null, 'X'],
    'int enum public => public' => [StringBackedEnum::PUBLIC, StringBackedEnum::PUBLIC],
    'int enum public => protected' => [StringBackedEnum::PUBLIC, StringBackedEnum::PROTECTED],
    'int enum public => private' => [StringBackedEnum::PUBLIC, StringBackedEnum::PRIVATE],
    'int enum protected => protected' => [StringBackedEnum::PROTECTED, StringBackedEnum::PROTECTED],
    'int enum protected => private' => [StringBackedEnum::PROTECTED, StringBackedEnum::PRIVATE],
    'int enum private => private' => [StringBackedEnum::PRIVATE, StringBackedEnum::PRIVATE],
]);

test('transition not permitted on laravel helper enum', function (?UnitEnum $from, null|int|UnitEnum $to) {
    $this->testModel->laravel_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->laravel_status = $to)->toThrow(StatusTransitionDenied::class);

})->with([
    'int enum public => null' => [LaravelEnum::PUBLIC, null],
    'int enum protected => public' => [LaravelEnum::PROTECTED, LaravelEnum::PUBLIC],
    'int enum protected => 2' => [LaravelEnum::PROTECTED, 2],
    'int enum protected => null' => [LaravelEnum::PROTECTED, null],
    'int enum private => public' => [LaravelEnum::PRIVATE, LaravelEnum::PUBLIC],
    'int enum private => 2' => [LaravelEnum::PRIVATE, 2],
    'int enum private => protected' => [LaravelEnum::PRIVATE, LaravelEnum::PROTECTED],
    'int enum private => 3' => [LaravelEnum::PRIVATE, 3],
    'int enum private => null' => [LaravelEnum::PRIVATE, null],
]);

test('transition permitted on laravel helper enum', function (?UnitEnum $from, null|int|UnitEnum $to) {
    $this->testModel->laravel_status = $from;
    $this->testModel->save();

    $model = TestModel::find($this->testModel->id);

    expect(fn () => $model->laravel_status = $to)->not->toThrow(StatusTransitionDenied::class);
    if ($to instanceof UnitEnum) {
        expect($model->laravel_status)->toBe($to);
    }

})->with([
    'int enum null => null' => [null, null],
    'int enum null => public' => [null, LaravelEnum::PUBLIC],
    'int enum null => 2' => [null, 2],
    'int enum null => protected' => [null, LaravelEnum::PROTECTED],
    'int enum null => 3' => [null, 3],
    'int enum null => private' => [null, LaravelEnum::PRIVATE],
    'int enum null => 1' => [null, 1],
    'int enum public => public' => [LaravelEnum::PUBLIC, LaravelEnum::PUBLIC],
    'int enum public => protected' => [LaravelEnum::PUBLIC, LaravelEnum::PROTECTED],
    'int enum public => private' => [LaravelEnum::PUBLIC, LaravelEnum::PRIVATE],
    'int enum protected => protected' => [LaravelEnum::PROTECTED, LaravelEnum::PROTECTED],
    'int enum protected => private' => [LaravelEnum::PROTECTED, LaravelEnum::PRIVATE],
    'int enum private => private' => [LaravelEnum::PRIVATE, LaravelEnum::PRIVATE],
]);
