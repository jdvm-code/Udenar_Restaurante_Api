<?php

namespace App\Providers;

use App\Http\Repository\UserRepository;
use App\Http\Services\BeneficiarioRepository;
use App\Http\Services\BeneficiarioServices;
use App\Http\Services\UserServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserServices::class,
            UserRepository::class
        );

            $this->app->bind(
                BeneficiarioServices::class,
                BeneficiarioRepository::class
            );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
