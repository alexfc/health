<?php

namespace Alexfc\Health;

use Alexfc\Health\Services\HealthService;
use Alexfc\Health\Services\HealthServiceInterface;
use Illuminate\Support\ServiceProvider;

class HealthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(HealthServiceInterface::class, HealthService::class);
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
    }
}