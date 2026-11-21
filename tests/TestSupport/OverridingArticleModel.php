<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport;

use Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums\ArticleStatus;

class OverridingArticleModel extends ArticleModel
{
    public function articleStatusTransitions(?ArticleStatus $from, ?ArticleStatus $to): bool
    {
        return true;
    }
}
