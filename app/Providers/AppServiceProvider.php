<?php

namespace App\Providers;

use App\Services\CandidacyService;
use App\Services\UserService;
use App\Services\EmployerService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserService::class, function () {
            return new UserService();
        });

        $this->app->singleton(EmployerService::class, function () {
            return new EmployerService();
        });


        $this->app->bind(NotificationService::class, function () {
            return new NotificationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //    
    }
}
