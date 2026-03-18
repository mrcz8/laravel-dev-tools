<?php

namespace Tawin\LaravelDevTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;

class ListPoliciesCommand extends Command
{
    protected $signature = 'list:policies';
    protected $description = 'List all registered policies';

    public function handle()
    {
        $policies = Gate::policies();

        if (empty($policies)) {
            $this->info('No policies registered.');
            return;
        }

        $rows = [];
        foreach ($policies as $model => $policy) {
            $rows[] = [$model, $policy];
        }

        $this->table(['Model', 'Policy'], $rows);
    }
}
