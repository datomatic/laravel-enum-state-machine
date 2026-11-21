<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Soft mode
    |--------------------------------------------------------------------------
    |
    | When enabled, a denied transition does not throw StatusTransitionDenied:
    | the new value is applied and the denial is logged instead. It can be
    | overridden on each cast: AsEnumStateMachine::of(Status::class, true).
    |
    */
    'soft_mode' => (bool) env('LARAVEL_ENUM_STATE_MACHINE_SOFT_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Soft mode logging
    |--------------------------------------------------------------------------
    |
    | The log channel (null for the default one) and level used to record
    | transitions denied in soft mode.
    |
    */
    'log_channel' => env('LARAVEL_ENUM_STATE_MACHINE_LOG_CHANNEL'),

    'log_level' => env('LARAVEL_ENUM_STATE_MACHINE_LOG_LEVEL', 'error'),
];
