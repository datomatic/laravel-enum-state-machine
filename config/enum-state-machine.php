<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Soft Mode Configuration
    |--------------------------------------------------------------------------
    |
    | The 'soft_mode' configuration allows for handling errors without
    | interrupting the application's execution. When this option is enabled,
    | no exceptions are thrown during state transitions and logged instead.
    | This helps prevent unexpected crashes, ensuring
    | greater application resilience, especially in scenarios where a failure
    | in the state machine should not disrupt the main program flow.
    | You can configure this modality for each model casting
    |
    */
    'soft_mode' => env('LARAVEL_ENUM_STATE_MACHINE_SOFT_MODE', false),
];
