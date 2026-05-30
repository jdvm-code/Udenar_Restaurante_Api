<?php

namespace App\Providers;

use App\Http\Services\BecaService;
use App\Http\Repository\BecaRepository;

use App\Http\Services\ComidaService;
use App\Http\Repository\ComidaRepository;

use App\Http\Repository\PermisoRepository;
use App\Http\Services\PermisoService;

use App\Http\Services\UserService;
use App\Http\Repository\UserRepository;

use App\Http\Services\EstadoBecaService;
use App\Http\Repository\EstadoBecaRepository;

use App\Http\Services\EstadoReservaService;
use App\Http\Repository\EstadoReservaRepository;

use App\Http\Services\HorarioService;
use App\Http\Repository\HorarioRepository;

use App\Http\Services\ReservaService;
use App\Http\Repository\ReservaRepository;

use App\Http\Repository\RoleRepository;
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
            EstadoBecaService::class,
            EstadoBecaRepository::class
        );

        $this->app->bind(
            EstadoReservaService::class,
            EstadoReservaRepository::class
        );


        $this->app->bind(
            BecaService::class,
            BecaRepository::class
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
            ReservaService::class,
            ReservaRepository::class
        );

        $this->app->bind(
            HorarioService::class,
            HorarioRepository::class
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
