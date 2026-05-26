<?php

namespace App\Providers;

use App\Http\Repository\BeneficiarioRepository;
use App\Http\Repository\ComidaRepository;
use App\Http\Repository\PermisoRepository;
use App\Http\Repository\UserRepository;
use App\Http\Services\BeneficiarioServices;
use App\Http\Services\ComidaService;
use App\Http\Services\PermisoServices;
use App\Http\Services\UserServices;
use App\Repository\EstadoAsistenciaRepository;
use App\Services\EstadoAsistenciaService;
use Illuminate\Support\Facades\Schema;
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

            $this->app->bind(
                PermisoServices::class,
                PermisoRepository::class
            );
             $this->app->bind(
                ComidaService::class,
                ComidaRepository::class
            );

            $this->app->bind(
                EstadoAsistenciaService::class,
                EstadoAsistenciaRepository::class
            );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
