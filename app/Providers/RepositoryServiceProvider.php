<?php

namespace App\Providers;

use App\Contract\Repositories\KoperasiRepositoryInterface;
use App\Contract\Repositories\UserRepositoryInterface;
use App\Contract\Repositories\WhatsappBotRepositoryInterface;
use App\Repositories\KoperasiRepository;
use App\Repositories\UserRepository;
use App\Repositories\WhatsappBotRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(KoperasiRepositoryInterface::class , KoperasiRepository::class);
        $this->app->bind(UserRepositoryInterface::class , UserRepository::class);
        $this->app->bind(WhatsappBotRepositoryInterface::class , WhatsappBotRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
