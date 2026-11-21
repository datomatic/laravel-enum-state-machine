<?php

declare(strict_types=1);

use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Casts\EnumStateMachineCast;
use Datomatic\LaravelEnumStateMachine\Events\TransitionDenied;
use Datomatic\LaravelEnumStateMachine\Events\Transitioning;
use Datomatic\LaravelEnumStateMachine\Exceptions\StatusTransitionDenied;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\ArticleModel;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\CastsMethodModel;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\ArticleStatus;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\IntBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\LaravelEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\PureEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\StringBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\TestModel;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

it('builds the cast string', function (?bool $softMode, string $expected) {
    expect(AsEnumStateMachine::of(PureEnum::class, $softMode))
        ->toBe(AsEnumStateMachine::class.':'.PureEnum::class.$expected);
})->with([
    'config default' => [null, ''],
    'soft mode' => [true, ',true'],
    'strict mode' => [false, ',false'],
]);

it('parses the soft mode argument', function (array $arguments, ?bool $expected) {
    expect(EnumStateMachineCast::fromArguments($arguments)->softMode)->toBe($expected);
})->with([
    'missing' => [[PureEnum::class], null],
    'true' => [[PureEnum::class, 'true'], true],
    '1' => [[PureEnum::class, '1'], true],
    'false' => [[PureEnum::class, 'false'], false],
    '0' => [[PureEnum::class, '0'], false],
]);

it('rejects an invalid soft mode argument', function () {
    EnumStateMachineCast::fromArguments([PureEnum::class, 'maybe']);
})->throws(InvalidArgumentException::class);

it('rejects a cast without an enum class', function () {
    EnumStateMachineCast::fromArguments([TestModel::class]);
})->throws(InvalidArgumentException::class);

it('keeps strict mode on a cast set to false when soft mode is enabled globally', function () {
    config()->set('enum-state-machine.soft_mode', true);

    $model = CastsMethodModel::create(['string_status' => StringBackedEnum::PRIVATE]);

    expect(fn () => $model->string_status = StringBackedEnum::PUBLIC)->toThrow(StatusTransitionDenied::class);
});

it('keeps strict mode on a cast built with of(false) when soft mode is enabled globally', function () {
    config()->set('enum-state-machine.soft_mode', true);

    $model = CastsMethodModel::create(['laravel_status' => LaravelEnum::PRIVATE]);

    expect(fn () => $model->laravel_status = LaravelEnum::PUBLIC)->toThrow(StatusTransitionDenied::class);
});

it('uses soft mode when the cast enables it', function () {
    $model = CastsMethodModel::create(['int_status' => IntBackedEnum::PRIVATE]);

    $model->int_status = IntBackedEnum::PUBLIC;

    expect($model->int_status)->toBe(IntBackedEnum::PUBLIC);
});

it('uses the global soft mode when the cast does not set it', function () {
    config()->set('enum-state-machine.soft_mode', true);

    $model = TestModel::create(['pure_status' => PureEnum::PRIVATE]);

    $model->pure_status = PureEnum::PUBLIC;

    expect($model->pure_status)->toBe(PureEnum::PUBLIC);
});

it('logs denied transitions in soft mode on the configured level', function () {
    config()->set('enum-state-machine.log_level', 'warning');

    $model = TestModel::create(['string_status' => StringBackedEnum::PRIVATE]);
    $logged = [];
    Log::listen(function (MessageLogged $message) use (&$logged) {
        $logged[] = $message;
    });

    $model->string_status = StringBackedEnum::PUBLIC;

    expect($logged)->toHaveCount(1)
        ->and($logged[0]->level)->toBe('warning')
        ->and($logged[0]->message)->toBe('Transition of [string_status] on ['.TestModel::class.'] from [PRIVATE] to [PUBLIC] is not allowed.')
        ->and($logged[0]->context)->toBe([
            'model' => TestModel::class,
            'key' => $model->id,
            'attribute' => 'string_status',
            'from' => 'PRIVATE',
            'to' => 'PUBLIC',
        ]);
});

it('exposes the transition on the exception', function () {
    $model = TestModel::create(['pure_status' => PureEnum::PRIVATE]);

    try {
        $model->pure_status = PureEnum::PUBLIC;
    } catch (StatusTransitionDenied $exception) {
        expect($exception->model)->toBe($model)
            ->and($exception->attribute)->toBe('pure_status')
            ->and($exception->from)->toBe(PureEnum::PRIVATE)
            ->and($exception->to)->toBe(PureEnum::PUBLIC)
            ->and($exception->getMessage())->toBe('Transition of [pure_status] on ['.TestModel::class.'] from [PRIVATE] to [PUBLIC] is not allowed.');

        return;
    }

    $this->fail('StatusTransitionDenied was not thrown.');
});

it('does not dirty the model when the same value is assigned again', function (string $attribute, UnitEnum $value) {
    $model = TestModel::create([$attribute => $value]);
    $model = TestModel::find($model->id);

    $model->{$attribute} = $value;

    expect($model->isDirty($attribute))->toBeFalse()
        ->and($model->getAttributes()[$attribute])->not->toBeInstanceOf(UnitEnum::class);
})->with([
    'pure enum' => ['pure_status', PureEnum::PUBLIC],
    'int backed enum' => ['int_status', IntBackedEnum::PUBLIC],
    'string backed enum' => ['string_status', StringBackedEnum::PUBLIC],
]);

it('treats a backed value of 0 as a state, not as the initial state', function () {
    $model = ArticleModel::create(['article_status' => ArticleStatus::DRAFT]);
    $model = ArticleModel::find($model->id);

    expect(fn () => $model->article_status = ArticleStatus::ARCHIVED)->toThrow(StatusTransitionDenied::class);
});

it('dispatches Transitioning when a transition is allowed', function () {
    Event::fake([Transitioning::class, TransitionDenied::class]);

    $model = TestModel::create(['pure_status' => PureEnum::PUBLIC]);
    $model->pure_status = PureEnum::PRIVATE;

    Event::assertDispatched(Transitioning::class, fn (Transitioning $event) => $event->model === $model
        && $event->attribute === 'pure_status'
        && $event->from === PureEnum::PUBLIC
        && $event->to === PureEnum::PRIVATE);
    Event::assertNotDispatched(TransitionDenied::class);
});

it('does not dispatch events when the value does not change', function () {
    $model = TestModel::create(['pure_status' => PureEnum::PUBLIC]);
    Event::fake([Transitioning::class, TransitionDenied::class]);

    $model->pure_status = PureEnum::PUBLIC;

    Event::assertNothingDispatched();
});

it('dispatches TransitionDenied before throwing', function () {
    Event::fake([TransitionDenied::class]);

    $model = TestModel::create(['pure_status' => PureEnum::PRIVATE]);

    expect(fn () => $model->pure_status = PureEnum::PUBLIC)->toThrow(StatusTransitionDenied::class);

    Event::assertDispatched(TransitionDenied::class, fn (TransitionDenied $event) => $event->from === PureEnum::PRIVATE
        && $event->to === PureEnum::PUBLIC
        && $event->softMode === false);
});

it('dispatches TransitionDenied in soft mode', function () {
    Event::fake([TransitionDenied::class]);

    $model = TestModel::create(['string_status' => StringBackedEnum::PRIVATE]);
    $model->string_status = StringBackedEnum::PUBLIC;

    Event::assertDispatched(TransitionDenied::class, fn (TransitionDenied $event) => $event->softMode === true);
});

it('rejects a value that is not a case of the enum', function () {
    $model = new TestModel;

    $model->pure_status = 'UNKNOWN';
})->throws(ValueError::class);
