<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums;

enum StringBackedEnum: string
{
    case PUBLIC = 'V';

    case PROTECTED = '-';

    case PRIVATE = 'X';
}
