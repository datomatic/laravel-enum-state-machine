<?php

declare(strict_types=1);

use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\ArticleModel;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\ArticleStatus;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\IntBackedEnum;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\TestModel;

it('checks a transition defined on the model without applying it', function () {
    $model = TestModel::create(['int_status' => IntBackedEnum::PUBLIC]);

    expect($model->canTransitionTo('int_status', IntBackedEnum::PRIVATE))->toBeTrue()
        ->and($model->canTransitionTo('int_status', 3))->toBeTrue()
        ->and($model->canTransitionTo('int_status', null))->toBeFalse()
        ->and($model->canTransitionTo('int_status', IntBackedEnum::PUBLIC))->toBeTrue()
        ->and($model->int_status)->toBe(IntBackedEnum::PUBLIC)
        ->and($model->isDirty())->toBeFalse();
});

it('checks a transition defined on the enum', function () {
    $model = ArticleModel::create(['article_status' => ArticleStatus::DRAFT]);

    expect($model->canTransitionTo('article_status', ArticleStatus::PUBLISHED))->toBeTrue()
        ->and($model->canTransitionTo('article_status', ArticleStatus::ARCHIVED))->toBeFalse();
});

it('checks the initial state of a new model', function () {
    $model = new ArticleModel;

    expect($model->canTransitionTo('article_status', ArticleStatus::DRAFT))->toBeTrue()
        ->and($model->canTransitionTo('article_status', ArticleStatus::PUBLISHED))->toBeFalse();
});

it('throws for an attribute not cast as an enum state machine', function () {
    (new TestModel)->canTransitionTo('id', 1);
})->throws(InvalidArgumentException::class);
