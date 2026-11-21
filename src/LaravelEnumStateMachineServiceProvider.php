<?php

declare(strict_types=1);

namespace Datomatic\LaravelEnumStateMachine;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelEnumStateMachineServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-enum-state-machine')
            ->hasConfigFile('enum-state-machine');

        $this->publishes([
            $this->package->basePath('/../stubs/LaravelEnumStateMachineModelIdeHelperHook.stub') => app_path('Support/IdeHelper/LaravelEnumStateMachineModelIdeHelperHook.php'),
        ], 'enum-state-machine-ide-helper-hooks');
    }
}
