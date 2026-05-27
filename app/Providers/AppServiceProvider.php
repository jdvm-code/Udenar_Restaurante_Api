<?php

namespace App\Providers;

use App\Http\Repository\AsistenciaRepository;
use App\Http\Repository\BeneficiarioRepository;
use App\Http\Repository\ComidaRepository;
use App\Http\Repository\PermisoRepository;
use App\Http\Repository\UserRepository;
use App\Http\Services\BeneficiarioService;
use App\Http\Services\ComidaService;
use App\Http\Services\EstadoAsistenciaService;
use App\Http\Services\PermisoService;
use App\Http\Services\UserService;
use App\Http\Repository\EstadoAsistenciaRepository;
use App\Http\Repository\RoleRepository;
use App\Http\Services\AsistenciaService;
use App\Http\Services\RoleService;
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
            UserService::class,
            UserRepository::class
        );

        $this->app->bind(
            RoleService::class,
            RoleRepository::class
        );

        $this->app->bind(
            BeneficiarioService::class,
            BeneficiarioRepository::class
        );

        $this->app->bind(
            PermisoService::class,
            PermisoRepository::class
        );
        $this->app->bind(
            ComidaService::class,
            ComidaRepository::class
        );

        $this->app->bind(
            AsistenciaService::class,
            AsistenciaRepository::class
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
