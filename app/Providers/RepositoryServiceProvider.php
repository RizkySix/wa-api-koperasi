<?php

namespace App\Providers;

use App\Contract\Repositories\KoperasiRepositoryInterface;
use App\Repositories\KoperasiRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(KoperasiRepositoryInterface::class , KoperasiRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
