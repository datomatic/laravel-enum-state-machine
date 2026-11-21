<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport;

use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Concerns\HasEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ArticleStatus|null $article_status
 */
class ArticleModel extends Model
{
    use HasEnumStateMachine;

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'article_status' => AsEnumStateMachine::of(ArticleStatus::class),
        ];
    }
}
