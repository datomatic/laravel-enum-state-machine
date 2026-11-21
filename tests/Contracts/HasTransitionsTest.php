<?php

declare(strict_types=1);

use Datomatic\LaravelEnumStateMachine\Exceptions\StatusTransitionDenied;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\ArticleModel;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\ArticleStatus;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\OverridingArticleModel;

it('allows the transitions defined on the enum', function () {
    $model = ArticleModel::create(['article_status' => ArticleStatus::DRAFT]);

    $model->article_status = ArticleStatus::PUBLISHED;
    $model->save();
    $model->article_status = ArticleStatus::ARCHIVED;
    $model->save();

    expect($model->fresh()->article_status)->toBe(ArticleStatus::ARCHIVED);
});

it('denies the transitions not defined on the enum', function (?ArticleStatus $from, ?ArticleStatus $to) {
    $model = $from === null
        ? new ArticleModel
        : ArticleModel::find(ArticleModel::query()->insertGetId(['article_status' => $from->value]));

    expect(fn () => $model->article_status = $to)->toThrow(StatusTransitionDenied::class);
})->with([
    'null => published' => [null, ArticleStatus::PUBLISHED],
    'draft => archived' => [ArticleStatus::DRAFT, ArticleStatus::ARCHIVED],
    'published => draft' => [ArticleStatus::PUBLISHED, ArticleStatus::DRAFT],
    'archived => published' => [ArticleStatus::ARCHIVED, ArticleStatus::PUBLISHED],
    'archived => null' => [ArticleStatus::ARCHIVED, null],
]);

it('gives precedence to the model transitions method over the enum', function () {
    $model = OverridingArticleModel::create(['article_status' => ArticleStatus::DRAFT]);

    $model->article_status = ArticleStatus::ARCHIVED;

    expect($model->article_status)->toBe(ArticleStatus::ARCHIVED);
});
