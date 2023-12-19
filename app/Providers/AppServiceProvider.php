<?php

namespace App\Providers;

use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Services\KoperasiService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(KoperasiServiceInterface::class , KoperasiService::class);
        $this->app->bind(UserServiceInterface::class , UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
