<?php

namespace App\Providers;

use App\Contract\Services\KoperasiServiceInterface;
use App\Services\KoperasiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(KoperasiServiceInterface::class , KoperasiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
