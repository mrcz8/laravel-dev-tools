<?php

namespace Tawin\LaravelDevTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

class ModelRelationsCommand extends Command
{
    protected $signature = 'model:relations {model}';
    protected $description = 'List all Eloquent relationships in a model';

    public function handle()
    {
        $modelClass = $this->argument('model');

        if (!class_exists($modelClass)) {
            $this->error("Class $modelClass does not exist.");
            return 1;
        }

        if (!is_subclass_of($modelClass, Model::class)) {
            $this->error("$modelClass is not an Eloquent model.");
            return 1;
        }

        $model = app($modelClass);
        $reflection = new ReflectionClass($model);
        $relations = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class !== $modelClass) {
                continue;
            }

            if ($method->getNumberOfParameters() > 0) {
                continue;
            }

            $returnType = $method->getReturnType();
            if ($returnType === null) {
                continue;
            }

            $typeName = $returnType instanceof \ReflectionNamedType ? $returnType->getName() : null;
            if ($typeName && is_subclass_of($typeName, Relation::class)) {
                $relations[] = [$method->getName(), class_basename($typeName)];
            }
        }

        if (empty($relations)) {
            $this->info("No relationships found for $modelClass.");
        } else {
            $this->table(['Method', 'Type'], $relations);
        }

        return 0;
    }
}
