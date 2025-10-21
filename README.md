![Enum Helper-Dark](branding/dark.png#gh-dark-mode-only)![Enum Helper-Light](branding/light.png#gh-light-mode-only)
# Laravel enum state machine

[![Latest Version on Packagist](https://img.shields.io/packagist/v/datomatic/laravel-enum-state-machine.svg?style=for-the-badge)](https://packagist.org/packages/datomatic/laravel-enum-state-machine)
[![Pest Tests number](https://img.shields.io/static/v1?label=%23tests&message=84&color=FF88FA&style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAABiVBMVEUAAAD/iPv9yP3Xm+j/mP//wfVj67Je6bP/h/pVx6p6175d57WQycf+iPn/iPrsnezArd3+t/qpvNJd6LP/jPpu6rv/lPr/kPpc57T/rvtc57Np6rj3oPl37cL/tfn/wv9d6brX//L/g/rYn+n/gvrWm+di6LX+jPrskfGWzMpt6bln4bdd57Jk6LWSycj+vPquwNVo6rde6bP7nvvYnup91b/+vfv/lvtc57OqvNTFs9//t/td57L9t/r/iPpd6LPapej/ovp26bxy67v9lfld6LJr4Ljwsvb/xv3/jv39zv1t6buG5cTDreH5ivlc5rJy676V4cxb57D/y/h50MOy4OCUxcVa77X/iPpe6LP/jP+pu9L8t///tvuQycfArNxp6LzArd151r7/i/9n4bb/j/9e6rT/ifr7ifrskvLYnuhi87tg8blg7bf/vv//lP+wxNtj9b3/qv//oP/+ivz/l/r8ifryn/fvlPTfpPDeofDKtujHtOWX1NF/4seC3cR82sFu7cBo5LiMwPMrAAAAWHRSTlMA/Wv8FAIC/dME/Wj+3tEG/Pv798G1oHRjS0k1LBsWDgsJ/v36+fTy8ezn4+Lh29XNzMzLysLAwLSwr66opJqakY+Ni4J7end0bGlpY11XU048KicmIR8fizl+vwAAAVdJREFUKM9tz2VXAlEQgOFBBURpkE67u7u7E1YFYQl1SbvrlztDiLvss+fc/fCemXMvAEhhKqU759P1rLoxUDUyEh9fPH0z7ALiVrEY+SSNtxNS2upouYv7hOL191aKVsZHUTgbnQPQgDkq4ctHdoQmTWmW4WFzlVUDVpNKXf2fWpWbZIwUq/hcmjWGYnSa1pZZjEoomrEdVAisD7CX6GEb40rqTODxCj21OjDOvjRV8l2jhudBDchg/FUbDIZCITzwQyH6a9+2AMDbm9GfltFnxgAdtQWUgQJl4VQq37uPcSnsfYZzav6Ew18fQ4fUYPM7Qn4uSiIdyx5saJ6T+/3+5KSltshicwI2UpfAKE/aoARTvnn7KMYMdlAUyWRSyHN2JeU42HlCi4TszTHcmuj3iMVdP5JzoyAWNzi6T3ZGrMFCliK3BAqRSC/B2+6IxvYYNcO+2Npfv+yFi10LfBUAAAAASUVORK5CYII=)](https://github.com/datomatic/laravel-enum-state-machine/tree/main/tests)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/datomatic/laravel-enum-state-machine/run-tests.yml?branch=main&label=tests&color=5FE8B3&style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAABiVBMVEUAAAD/iPv9yP3Xm+j/mP//wfVj67Je6bP/h/pVx6p6175d57WQycf+iPn/iPrsnezArd3+t/qpvNJd6LP/jPpu6rv/lPr/kPpc57T/rvtc57Np6rj3oPl37cL/tfn/wv9d6brX//L/g/rYn+n/gvrWm+di6LX+jPrskfGWzMpt6bln4bdd57Jk6LWSycj+vPquwNVo6rde6bP7nvvYnup91b/+vfv/lvtc57OqvNTFs9//t/td57L9t/r/iPpd6LPapej/ovp26bxy67v9lfld6LJr4Ljwsvb/xv3/jv39zv1t6buG5cTDreH5ivlc5rJy676V4cxb57D/y/h50MOy4OCUxcVa77X/iPpe6LP/jP+pu9L8t///tvuQycfArNxp6LzArd151r7/i/9n4bb/j/9e6rT/ifr7ifrskvLYnuhi87tg8blg7bf/vv//lP+wxNtj9b3/qv//oP/+ivz/l/r8ifryn/fvlPTfpPDeofDKtujHtOWX1NF/4seC3cR82sFu7cBo5LiMwPMrAAAAWHRSTlMA/Wv8FAIC/dME/Wj+3tEG/Pv798G1oHRjS0k1LBsWDgsJ/v36+fTy8ezn4+Lh29XNzMzLysLAwLSwr66opJqakY+Ni4J7end0bGlpY11XU048KicmIR8fizl+vwAAAVdJREFUKM9tz2VXAlEQgOFBBURpkE67u7u7E1YFYQl1SbvrlztDiLvss+fc/fCemXMvAEhhKqU759P1rLoxUDUyEh9fPH0z7ALiVrEY+SSNtxNS2upouYv7hOL191aKVsZHUTgbnQPQgDkq4ctHdoQmTWmW4WFzlVUDVpNKXf2fWpWbZIwUq/hcmjWGYnSa1pZZjEoomrEdVAisD7CX6GEb40rqTODxCj21OjDOvjRV8l2jhudBDchg/FUbDIZCITzwQyH6a9+2AMDbm9GfltFnxgAdtQWUgQJl4VQq37uPcSnsfYZzav6Ew18fQ4fUYPM7Qn4uSiIdyx5saJ6T+/3+5KSltshicwI2UpfAKE/aoARTvnn7KMYMdlAUyWRSyHN2JeU42HlCi4TszTHcmuj3iMVdP5JzoyAWNzi6T3ZGrMFCliK3BAqRSC/B2+6IxvYYNcO+2Npfv+yFi10LfBUAAAAASUVORK5CYII=)](https://github.com/datomatic/laravel-enum-state-machine/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/datomatic/laravel-enum-state-machine/fix-php-code-style-issues.yml?label=code%20style&color=5FE8B3&style=for-the-badge)](https://github.com/datomatic/laravel-enum-state-machine/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/datomatic/laravel-enum-state-machine.svg?style=for-the-badge)](https://packagist.org/packages/datomatic/laravel-enum-state-machine)

This package it's simple state transitions control for enums in Laravel, this is not an implementation of state machine pattern.
Allowing you to prevent unlogically transition and also controlling the initial state of the enum fields on your models.

## Installation
Laravel 10+ and PHP 8.2+ are required.

You can install the package via composer:

```bash
composer require datomatic/laravel-enum-state-machine
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="enum-state-machine-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="enum-state-machine-config"
```

This is the contents of the published config file:

```php
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
```


### Using Laravel IDE Helper?
If you are using [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper), you need to run the following command:

```bash
php artisan vendor:publish --tag="enum-state-machine-ide-helper-hooks"
```
and add `LaravelEnumStateMachineModelIdeHelperHook::class` on `model_hooks` array in `config/ide-helper.php`

```php
    'model_hooks' => [
        ...,
        LaravelEnumStateMachineModelIdeHelperHook::class,
    ],
```

## Usage

Laravel enum state machine it's a simple state transitions control for enums in Laravel, this is not an implementation of state machine pattern.

In the default mode, if the transition is not allowed, an exception `StatusTransitionDenied` will be thrown.
In the soft mode, if the transition is not allowed, an error message will be logged.

### Setting the model

You need to define the casts in your model and the transition control function.
The first param on the casting is the enum class and the optional second param is the soft mode modality (if no second param is passed, the default mode configured in config file is used).
You can cast multiple fields if needed.
The transition method name is composed by the enum field name (camelCase) + Transitions and serve to define whether a transition is allowed or not.


```php
class TestModel extends Model
{
    //Laravel 10
    protected $casts = [
        'status' => AsEnumStateMachine::class.':'.StatusEnum::class,  // ',true' for soft mode
    ];
    
    //Laravel 11
    protected function casts(): array
    {
        return [
            'status' => AsEnumStateMachine::of(FieldEnum::class, false),
        ];
    }

    /** 
     * This method name is composed by the enum field name (camelCase) + Transitions 
     */
    public function statusTransitions(?StatusEnum $from, ?StatusEnum $to): bool
    {
        return match ($from) {
            null => true, // initial state permitted to all states
            StatusEnum::PUBLIC => match ($to) {
                StatusEnum::PRIVATE => true,
                StatusEnum::PROTECTED => true,
                null => false,
                default => false
            },
            StatusEnum::PROTECTED => match ($to) {
                StatusEnum::PRIVATE => true,
                StatusEnum::PUBLIC => false,
                default => false
            },
            StatusEnum::PRIVATE => false, //final state
            default => true
        };
    }
```

### Use the model

```php
$model = new TestModel;
$model->status = StatusEnum::PUBLIC; // OK
$model->save();

$model = TestModel::find(1);
$model->status; // StatusEnum::PUBLIC
$model->status = StatusEnum::PRIVATE; // OK
$model->status = StatusEnum::PUBLIC; // thrown `StatusTransitionDenied`
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Alberto Peripolli](https://github.com/trippo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
