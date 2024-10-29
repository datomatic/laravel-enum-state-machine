<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Tests\TestSupport\Enums;

enum PureEnum
{
    case PUBLIC;

    case PROTECTED;

    case PRIVATE;

}
