![Enum Helper-Dark](branding/dark.png#gh-dark-mode-only)![Enum Helper-Light](branding/light.png#gh-light-mode-only)
# Laravel enum state machine

[![Latest Version on Packagist](https://img.shields.io/packagist/v/datomatic/laravel-enum-state-machine.svg?style=for-the-badge)](https://packagist.org/packages/datomatic/laravel-enum-state-machine)
[![Pest Tests number](https://img.shields.io/static/v1?label=%23tests&message=119&color=FF88FA&style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAABiVBMVEUAAAD/iPv9yP3Xm+j/mP//wfVj67Je6bP/h/pVx6p6175d57WQycf+iPn/iPrsnezArd3+t/qpvNJd6LP/jPpu6rv/lPr/kPpc57T/rvtc57Np6rj3oPl37cL/tfn/wv9d6brX//L/g/rYn+n/gvrWm+di6LX+jPrskfGWzMpt6bln4bdd57Jk6LWSycj+vPquwNVo6rde6bP7nvvYnup91b/+vfv/lvtc57OqvNTFs9//t/td57L9t/r/iPpd6LPapej/ovp26bxy67v9lfld6LJr4Ljwsvb/xv3/jv39zv1t6buG5cTDreH5ivlc5rJy676V4cxb57D/y/h50MOy4OCUxcVa77X/iPpe6LP/jP+pu9L8t///tvuQycfArNxp6LzArd151r7/i/9n4bb/j/9e6rT/ifr7ifrskvLYnuhi87tg8blg7bf/vv//lP+wxNtj9b3/qv//oP/+ivz/l/r8ifryn/fvlPTfpPDeofDKtujHtOWX1NF/4seC3cR82sFu7cBo5LiMwPMrAAAAWHRSTlMA/Wv8FAIC/dME/Wj+3tEG/Pv798G1oHRjS0k1LBsWDgsJ/v36+fTy8ezn4+Lh29XNzMzLysLAwLSwr66opJqakY+Ni4J7end0bGlpY11XU048KicmIR8fizl+vwAAAVdJREFUKM9tz2VXAlEQgOFBBURpkE67u7u7E1YFYQl1SbvrlztDiLvss+fc/fCemXMvAEhhKqU759P1rLoxUDUyEh9fPH0z7ALiVrEY+SSNtxNS2upouYv7hOL191aKVsZHUTgbnQPQgDkq4ctHdoQmTWmW4WFzlVUDVpNKXf2fWpWbZIwUq/hcmjWGYnSa1pZZjEoomrEdVAisD7CX6GEb40rqTODxCj21OjDOvjRV8l2jhudBDchg/FUbDIZCITzwQyH6a9+2AMDbm9GfltFnxgAdtQWUgQJl4VQq37uPcSnsfYZzav6Ew18fQ4fUYPM7Qn4uSiIdyx5saJ6T+/3+5KSltshicwI2UpfAKE/aoARTvnn7KMYMdlAUyWRSyHN2JeU42HlCi4TszTHcmuj3iMVdP5JzoyAWNzi6T3ZGrMFCliK3BAqRSC/B2+6IxvYYNcO+2Npfv+yFi10LfBUAAAAASUVORK5CYII=)](https://github.com/datomatic/laravel-enum-state-machine/tree/main/tests)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/datomatic/laravel-enum-state-machine/run-tests.yml?branch=main&label=tests&color=5FE8B3&style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAABiVBMVEUAAAD/iPv9yP3Xm+j/mP//wfVj67Je6bP/h/pVx6p6175d57WQycf+iPn/iPrsnezArd3+t/qpvNJd6LP/jPpu6rv/lPr/kPpc57T/rvtc57Np6rj3oPl37cL/tfn/wv9d6brX//L/g/rYn+n/gvrWm+di6LX+jPrskfGWzMpt6bln4bdd57Jk6LWSycj+vPquwNVo6rde6bP7nvvYnup91b/+vfv/lvtc57OqvNTFs9//t/td57L9t/r/iPpd6LPapej/ovp26bxy67v9lfld6LJr4Ljwsvb/xv3/jv39zv1t6buG5cTDreH5ivlc5rJy676V4cxb57D/y/h50MOy4OCUxcVa77X/iPpe6LP/jP+pu9L8t///tvuQycfArNxp6LzArd151r7/i/9n4bb/j/9e6rT/ifr7ifrskvLYnuhi87tg8blg7bf/vv//lP+wxNtj9b3/qv//oP/+ivz/l/r8ifryn/fvlPTfpPDeofDKtujHtOWX1NF/4seC3cR82sFu7cBo5LiMwPMrAAAAWHRSTlMA/Wv8FAIC/dME/Wj+3tEG/Pv798G1oHRjS0k1LBsWDgsJ/v36+fTy8ezn4+Lh29XNzMzLysLAwLSwr66opJqakY+Ni4J7end0bGlpY11XU048KicmIR8fizl+vwAAAVdJREFUKM9tz2VXAlEQgOFBBURpkE67u7u7E1YFYQl1SbvrlztDiLvss+fc/fCemXMvAEhhKqU759P1rLoxUDUyEh9fPH0z7ALiVrEY+SSNtxNS2upouYv7hOL191aKVsZHUTgbnQPQgDkq4ctHdoQmTWmW4WFzlVUDVpNKXf2fWpWbZIwUq/hcmjWGYnSa1pZZjEoomrEdVAisD7CX6GEb40rqTODxCj21OjDOvjRV8l2jhudBDchg/FUbDIZCITzwQyH6a9+2AMDbm9GfltFnxgAdtQWUgQJl4VQq37uPcSnsfYZzav6Ew18fQ4fUYPM7Qn4uSiIdyx5saJ6T+/3+5KSltshicwI2UpfAKE/aoARTvnn7KMYMdlAUyWRSyHN2JeU42HlCi4TszTHcmuj3iMVdP5JzoyAWNzi6T3ZGrMFCliK3BAqRSC/B2+6IxvYYNcO+2Npfv+yFi10LfBUAAAAASUVORK5CYII=)](https://github.com/datomatic/laravel-enum-state-machine/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/datomatic/laravel-enum-state-machine/fix-php-code-style-issues.yml?label=code%20style&color=5FE8B3&style=for-the-badge)](https://github.com/datomatic/laravel-enum-state-machine/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/datomatic/laravel-enum-state-machine.svg?style=for-the-badge)](https://packagist.org/packages/datomatic/laravel-enum-state-machine)

Guard the transitions of enum attributes on your Eloquent models.

Cast an attribute with `AsEnumStateMachine`, describe which transitions are allowed, and every assignment is checked: a denied transition throws `StatusTransitionDenied` (or is logged, in soft mode). It is a lightweight transition guard, not a full implementation of the state pattern.

Pure enums, int and string backed enums are supported.

## Requirements

| Package | Version |
|---------|---------|
| PHP | 8.2 – 8.6 |
| Laravel | 11, 12, 13 |

## Installation

```bash
composer require datomatic/laravel-enum-state-machine
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="enum-state-machine-config"
```

```php
return [
    // Log denied transitions instead of throwing StatusTransitionDenied
    'soft_mode' => (bool) env('LARAVEL_ENUM_STATE_MACHINE_SOFT_MODE', false),

    // Log channel (null = default channel) and level used in soft mode
    'log_channel' => env('LARAVEL_ENUM_STATE_MACHINE_LOG_CHANNEL'),
    'log_level' => env('LARAVEL_ENUM_STATE_MACHINE_LOG_LEVEL', 'error'),
];
```

## Usage

### 1. Cast the attribute

```php
use Datomatic\LaravelEnumStateMachine\Casts\AsEnumStateMachine;
use Datomatic\LaravelEnumStateMachine\Concerns\HasEnumStateMachine;

class Order extends Model
{
    use HasEnumStateMachine; // optional, adds canTransitionTo()

    protected function casts(): array
    {
        return [
            'status' => AsEnumStateMachine::of(OrderStatus::class),
            'payment_status' => AsEnumStateMachine::of(PaymentStatus::class, softMode: true),
        ];
    }
}
```

The second argument of `of()` overrides the `soft_mode` config for that attribute: `true` enables it, `false` disables it, `null` (default) uses the config. The string syntax works as well: `AsEnumStateMachine::class.':'.OrderStatus::class.',true'`.

### 2. Define the allowed transitions

`$from` is `null` when the attribute has no value yet (the initial state), `$to` is `null` when the attribute is being cleared. Assigning the current value again is always allowed and is not checked.

**On the enum**, implementing `HasTransitions`. The rules live with the states and are shared by every model using the enum:

```php
use Datomatic\LaravelEnumStateMachine\Contracts\HasTransitions;
use Illuminate\Database\Eloquent\Model;

enum OrderStatus: string implements HasTransitions
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Cancelled = 'cancelled';

    public static function canTransition(?UnitEnum $from, ?UnitEnum $to, Model $model): bool
    {
        return match ($from) {
            null => $to === self::Pending,
            self::Pending => in_array($to, [self::Paid, self::Cancelled], true),
            self::Paid => $to === self::Shipped,
            default => false, // Shipped and Cancelled are final states
        };
    }
}
```

**On the model**, with a method named after the attribute (camelCase) followed by `Transitions`. It takes precedence over the enum rules, so you can use it to override them for a single model:

```php
class Order extends Model
{
    public function statusTransitions(?OrderStatus $from, ?OrderStatus $to): bool
    {
        return match ($from) {
            null => true,
            OrderStatus::Pending => $to !== null,
            default => false,
        };
    }
}
```

When neither is defined, every transition is allowed.

### 3. Assign values

Enum cases, backing values and (for pure enums) case names are accepted:

```php
$order = Order::create(['status' => OrderStatus::Pending]);

$order->status = OrderStatus::Paid; // OK
$order->status = 'shipped';         // OK
$order->status = OrderStatus::Pending; // throws StatusTransitionDenied
```

The exception exposes the transition:

```php
use Datomatic\LaravelEnumStateMachine\Exceptions\StatusTransitionDenied;

try {
    $order->status = OrderStatus::Pending;
} catch (StatusTransitionDenied $exception) {
    $exception->model;     // the Order
    $exception->attribute; // 'status'
    $exception->from;      // OrderStatus::Shipped
    $exception->to;        // OrderStatus::Pending
}
```

### Checking a transition without applying it

With the `HasEnumStateMachine` trait, for example to show or hide a button:

```php
$order->canTransitionTo('status', OrderStatus::Shipped); // bool
```

### Soft mode

In soft mode a denied transition does not throw: the value is applied and a message is written to the configured log channel and level, with the model class, key, attribute, `from` and `to` in the context.

### Events

| Event | When |
|-------|------|
| `Datomatic\LaravelEnumStateMachine\Events\Transitioning` | an allowed transition is applied to the attribute (before the model is saved) |
| `Datomatic\LaravelEnumStateMachine\Events\TransitionDenied` | a transition is denied, before the exception is thrown or the message is logged (`$event->softMode` tells which) |

Both expose `model`, `attribute`, `from` and `to`.

```php
Event::listen(function (TransitionDenied $event) {
    report("Denied {$event->attribute} transition on order {$event->model->getKey()}");
});
```

### Using Laravel IDE Helper?

If you are using [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper), publish the model hook:

```bash
php artisan vendor:publish --tag="enum-state-machine-ide-helper-hooks"
```

and add it to the `model_hooks` array in `config/ide-helper.php`:

```php
'model_hooks' => [
    // ...
    \App\Support\IdeHelper\LaravelEnumStateMachineModelIdeHelperHook::class,
],
```

## Upgrading from 0.x

- Laravel 10 is no longer supported.
- `StatusTransitionDenied` is now built with the model, the attribute and the `from`/`to` enums (all available as public properties) and its message changed. Update the code that creates or parses it.
- The soft mode argument of the cast is parsed as a boolean: `',false'` and `of(Enum::class, false)` now really disable soft mode (before, `',false'` enabled it and `of(..., false)` fell back to the config).
- Soft mode logs through `log_channel`/`log_level` (default: the default channel, `error`) with the details in the log context.
- Assigning the current value again no longer marks the attribute as dirty.
- A backed value of `0` (or `''`) is now treated as a state, not as the initial `null` state.

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
