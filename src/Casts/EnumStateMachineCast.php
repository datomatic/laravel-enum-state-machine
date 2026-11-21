<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine\Casts;

use Datomatic\LaravelEnumStateMachine\Events\TransitionDenied;
use Datomatic\LaravelEnumStateMachine\Events\Transitioning;
use Datomatic\LaravelEnumStateMachine\Exceptions\StatusTransitionDenied;
use Datomatic\LaravelEnumStateMachine\Support\EnumValue;
use Datomatic\LaravelEnumStateMachine\Support\Transitions;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use UnitEnum;

/**
 * @implements CastsAttributes<UnitEnum|null, UnitEnum|int|string|null>
 */
class EnumStateMachineCast implements CastsAttributes
{
    /**
     * @param  class-string<UnitEnum>  $enumClass
     */
    public function __construct(
        public string $enumClass,
        public ?bool $softMode = null,
    ) {}

    /**
     * @param  array<int, string>  $arguments
     */
    public static function fromArguments(array $arguments): self
    {
        $enumClass = $arguments[0] ?? null;

        if (! is_string($enumClass) || ! enum_exists($enumClass)) {
            throw new InvalidArgumentException('The '.AsEnumStateMachine::class.' cast requires an enum class as first argument.');
        }

        return new self($enumClass, self::parseSoftMode($arguments[1] ?? null));
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?UnitEnum
    {
        return EnumValue::toEnum($this->enumClass, $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int|string|null
    {
        $from = EnumValue::toEnum($this->enumClass, $attributes[$key] ?? null);
        $to = EnumValue::toEnum($this->enumClass, $value);

        if ($from !== $to) {
            $this->guardTransition($model, $key, $from, $to);
        }

        return EnumValue::toStorable($to);
    }

    private function guardTransition(Model $model, string $attribute, ?UnitEnum $from, ?UnitEnum $to): void
    {
        if (Transitions::allows($model, $attribute, $from, $to)) {
            event(new Transitioning($model, $attribute, $from, $to));

            return;
        }

        $softMode = $this->softMode ?? (bool) config('enum-state-machine.soft_mode', false);

        event(new TransitionDenied($model, $attribute, $from, $to, $softMode));

        $exception = new StatusTransitionDenied($model, $attribute, $from, $to);

        if (! $softMode) {
            throw $exception;
        }

        /** @var string|null $channel */
        $channel = config('enum-state-machine.log_channel');

        /** @var string $level */
        $level = config('enum-state-machine.log_level', 'error');

        logger()->channel($channel)->log($level, $exception->getMessage(), [
            'model' => $model::class,
            'key' => $model->getKey(),
            'attribute' => $attribute,
            'from' => $from?->name,
            'to' => $to?->name,
        ]);
    }

    private static function parseSoftMode(?string $value): ?bool
    {
        if ($value === null || $value === '') {
            return null;
        }

        $softMode = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($softMode === null) {
            throw new InvalidArgumentException("Invalid soft mode value [{$value}] for the ".AsEnumStateMachine::class.' cast.');
        }

        return $softMode;
    }
}
