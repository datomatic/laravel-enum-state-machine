<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelEnumStateMachineServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-enum-state-machine')
            ->hasConfigFile();

        $this->publishes([
            $this->package->basePath('/../stubs/LaravelEnumStateMachineModelIdeHelperHook.stub') => app_path('Support/IdeHelper/LaravelEnumStateMachineModelIdeHelperHook.php'),
        ], 'enum-state-machine-ide-helper-hooks');
    }
}
