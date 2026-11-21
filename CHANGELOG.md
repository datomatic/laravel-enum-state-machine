# Changelog

All notable changes to `laravel-enum-state-machine` will be documented in this file.

## v1.0.0 - 2026-11-21

### Breaking

- Requires Laravel 11, 12 or 13 (Laravel 10 dropped). PHP 8.2 – 8.6.
- `StatusTransitionDenied` now exposes `model`, `attribute`, `from` and `to` as public properties, and its message changed.
- The cast soft mode argument is parsed as a boolean (see Fixed).

### Added

- `HasTransitions` contract: define the allowed transitions on the enum. The model `{attribute}Transitions()` method still takes precedence.
- `HasEnumStateMachine` trait with `canTransitionTo($attribute, $to)` to check a transition without applying it.
- `Transitioning` and `TransitionDenied` events.
- `log_channel` and `log_level` config for soft mode; the log context contains model, key, attribute, from and to.

### Fixed

- `',false'` on the cast enabled soft mode, and `of(Enum::class, false)` fell back to the config: both now disable soft mode.
- Assigning the current value again stored the enum instance in the attributes and marked the attribute dirty.
- A backed value of `0` or `''` was treated as the initial (null) state, so every transition from it was allowed.
- Unknown case names on pure enums now throw a `ValueError`.

### Other

- README rewritten, with an upgrade guide from 0.x.
- More tests (119), CI for Laravel 11–13 and PHP 8.2–8.6, skeleton leftovers removed.

### What's Changed

* Bump dependabot/fetch-metadata from 2.5.0 to 3.1.0 by @dependabot[bot] in https://github.com/datomatic/laravel-enum-state-machine/pull/13
* Bump actions/checkout from 6 to 7 by @dependabot[bot] in https://github.com/datomatic/laravel-enum-state-machine/pull/14

**Full Changelog**: https://github.com/datomatic/laravel-enum-state-machine/compare/v0.4.0...v1.0.0

## v0.4.0 - 2026-11-20

Adds PHP 8.6 support (CI now runs on PHP 8.6).

### What's Changed

* Bump ramsey/composer-install from 3 to 4 by @dependabot[bot] in https://github.com/datomatic/laravel-enum-state-machine/pull/11

**Full Changelog**: https://github.com/datomatic/laravel-enum-state-machine/compare/v0.3.1...v0.4.0

## v0.3.1 - 2026-03-17

Laravel 13 support

## v0.3.0 - 2025-02-24

- Laravel 12 support

## v0.2.0 - 2024-12-10

- added Laravel IDE helper model hook

## v0.1.1 - 2024-11-18

- fix the config file name

## v0.1.0 - 2024-11-18

First release
