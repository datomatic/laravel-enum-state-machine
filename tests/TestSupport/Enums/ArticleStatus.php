<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums;

use Datomatic\LaravelEnumStateMachine\Contracts\HasTransitions;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

enum ArticleStatus: int implements HasTransitions
{
    case DRAFT = 0;

    case PUBLISHED = 1;

    case ARCHIVED = 2;

    public static function canTransition(?UnitEnum $from, ?UnitEnum $to, Model $model): bool
    {
        return match ($from) {
            null => $to === self::DRAFT,
            self::DRAFT => $to === self::PUBLISHED,
            self::PUBLISHED => $to === self::ARCHIVED,
            default => false,
        };
    }
}
