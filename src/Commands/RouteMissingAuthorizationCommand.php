<?php

namespace Tawin\LaravelDevTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class RouteMissingAuthorizationCommand extends Command
{
    protected $signature = 'route:missing-authorization';
    protected $description = 'List routes without auth middleware or policies';

    public function handle()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            $middleware = $route->gatherMiddleware();
            return !collect($middleware)->contains(function ($m) {
                return str_contains($m, 'auth') || str_contains($m, 'can:');
            });
        });

        if ($routes->isEmpty()) {
            $this->info("All routes have authorization middleware or policies.");
            return;
        }

        $this->info("Routes missing authorization:");
        foreach ($routes as $route) {
            $this->line($route->uri());
        }
    }
}
