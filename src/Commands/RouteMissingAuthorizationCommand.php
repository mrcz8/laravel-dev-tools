<?php

namespace Tawin\LaravelDevTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class RouteMissingAuthorizationCommand extends Command
{
    protected $signature = 'route:missing-authorization';
    protected $description = 'List routes without auth middleware or policies';

    protected array $authMiddleware = [
        'auth',
        'auth:',
        'can:',
        'auth.basic',
    ];

    public function handle()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            $middleware = collect($route->gatherMiddleware());

            return !$middleware->contains(function ($m) {
                if (!is_string($m)) {
                    return false;
                }

                foreach ($this->authMiddleware as $auth) {
                    if ($m === $auth || str_starts_with($m, $auth)) {
                        return true;
                    }
                }

                return false;
            });
        });

        if ($routes->isEmpty()) {
            $this->info('All routes have authorization middleware or policies.');
            return 0;
        }

        $rows = [];
        foreach ($routes as $route) {
            $rows[] = [
                implode('|', $route->methods()),
                $route->uri(),
                $route->getActionName(),
            ];
        }

        $this->info('Routes missing authorization:');
        $this->table(['Method', 'URI', 'Action'], $rows);

        return 1;
    }
}
