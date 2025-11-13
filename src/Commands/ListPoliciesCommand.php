<?php

namespace Tawin\LaravelDevTools\Commands;

use Illuminate\Console\Command;
use App\Providers\AuthServiceProvider;

class ListPoliciesCommand extends Command
{
    protected $signature = 'list:policies';
    protected $description = 'List all registered policies';

    public function handle()
    {
        $policies = app(AuthServiceProvider::class)->policies;

        if (empty($policies)) {
            $this->info('No policies registered.');
            return;
        }

        foreach ($policies as $model => $policy) {
            $this->line("$model => $policy");
        }
    }
}
