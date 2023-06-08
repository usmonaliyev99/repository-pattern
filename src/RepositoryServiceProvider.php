<?php

namespace Usmonaliyev\RepositoryPattern;

use Illuminate\Support\ServiceProvider;
use Usmonaliyev\RepositoryPattern\Console\CreatePatternCommand;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreatePatternCommand::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    public function register()
    {
    }
}
