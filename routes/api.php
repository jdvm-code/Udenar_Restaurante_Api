<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\EstadoBecaController;
use App\Http\Controllers\EstadoReservaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


///rutas de autenticacion
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/index', [AuthController::class, 'index']);

//rutas de usuarios
Route::get('/list', [UserController::class, 'index']);
Route::get('/find/{id}', [UserController::class, 'show']);
Route::put('/actualizar/{id}', [UserController::class, 'update']);
Route::delete('/eliminar/{id}', [UserController::class, 'destroy']);
Route::put('/usuarios/{id}/cambiar-password', [UserController::class, 'cambiarPassword']);


//rutas protegidas por autenticacion
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', [AuthController::class, 'me']);

});

//rutas de reservas
Route::apiResource('reserva', ReservaController::class);
Route::post('/reservas/verificar-qr', [ReservaController::class, 'verificarQR']);

//rutas de recursos
Route::apiResource('comida', ComidaController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('permisos', PermisoController::class);
Route::apiResource('estado-reserva', EstadoReservaController::class);
Route::apiResource('estado-beca', EstadoBecaController::class);
Route::apiResource('horario', HorarioController::class);
Route::apiResource('becas', BecaController::class);

Route::post('/roles/asignar-permiso', [RoleController::class, 'asignarPermiso']);


//rutas de reportes
Route::get('/beneficios-perdidos', [ReporteController::class, 'estudiantesInactivos']);
    
    // 2. Tráfico e histórico del restaurante
    Route::get('/trafico', [ReporteController::class, 'traficoRestaurante']);
    
    // 3. Estudiantes con determinado número de inasistencias
    Route::get('/inasistencias', [ReporteController::class, 'estudiantesConInasistencias']);
    
    // 4. Reportes Extra sugeridos
    Route::get('/balance-comidas', [ReporteController::class, 'balanceComidas']);
    Route::get('/eficiencia-reservas', [ReporteController::class, 'eficienciaReservas']);












