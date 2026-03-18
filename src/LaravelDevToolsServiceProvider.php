<?php

namespace Tawin\LaravelDevTools;

use Illuminate\Support\ServiceProvider;
use Tawin\LaravelDevTools\Commands\ListPoliciesCommand;
use Tawin\LaravelDevTools\Commands\ModelRelationsCommand;
use Tawin\LaravelDevTools\Commands\RouteMissingAuthorizationCommand;

class LaravelDevToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ListPoliciesCommand::class,
                ModelRelationsCommand::class,
                RouteMissingAuthorizationCommand::class,
            ]);
        }
    }
}
