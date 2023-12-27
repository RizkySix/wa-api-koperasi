<?php

namespace App\Providers;

use App\Contract\Services\GeneralWalletServiceInterface;
use App\Contract\Services\KoperasiServiceInterface;
use App\Contract\Services\UserServiceInterface;
use App\Contract\Services\WhatsappBotServiceInterface;
use App\Services\GeneralWalletService;
use App\Services\KoperasiService;
use App\Services\UserService;
use App\Services\WhatsappBotService;
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
        $this->app->bind(WhatsappBotServiceInterface::class , WhatsappBotService::class);
        $this->app->bind(GeneralWalletServiceInterface::class , GeneralWalletService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
