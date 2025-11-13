<?php

namespace Tawin\LaravelDevTools\Commands;

use Illuminate\Console\Command;
use ReflectionMethod;

class ModelRelationsCommand extends Command
{
    protected $signature = 'model:relations {model}';
    protected $description = 'List all Eloquent relationships in a model';

    public function handle()
    {
        $modelClass = $this->argument('model');

        if (!class_exists($modelClass)) {
            $this->error("Model $modelClass does not exist.");
            return;
        }

        $model = new $modelClass;
        $methods = get_class_methods($model);
        $relations = [];

        foreach ($methods as $method) {
            if ($method === '__construct') continue;

            $reflection = new ReflectionMethod($model, $method);
            if ($reflection->getNumberOfParameters() === 0) {
                try {
                    $return = $reflection->invoke($model);
                    if (method_exists($return, 'getRelationName')) {
                        $relations[] = $method;
                    }
                } catch (\Throwable $e) {
                    continue;
                }
            }
        }

        if (empty($relations)) {
            $this->info("No relationships found for $modelClass.");
        } else {
            $this->info("Relationships for $modelClass:");
            foreach ($relations as $relation) {
                $this->line("- $relation");
            }
        }
    }
}
