<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\EstadoBecaController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EstadoReservaController;
use App\Http\Controllers\ReporteController;


// ============================================
// RUTAS PÚBLICAS (Sin token)
// ============================================
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ============================================
// RUTAS PROTEGIDAS (Requieren Bearer Token)
// ============================================
Route::middleware('auth:api')->group(function () {

    // --- AUTH ---
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('index', [AuthController::class, 'index']); // Tu endpoint Postman "index"

    // --- USUARIOS (tus endpoints de Postman) ---
    Route::get('list', [UserController::class, 'index']);        // GET /api/list
    Route::get('find/{id}', [UserController::class, 'show']);    // GET /api/find/17
    Route::put('find/{id}', [UserController::class, 'update']);   // PUT /api/find/17
    Route::delete('delete/{id}', [UserController::class, 'destroy']); // DELETE /api/delete/18
    Route::put('usuarios/{id}/cambiar-password', [UserController::class, 'cambiarPassword']);

    // --- ROLES ---
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::delete('roles/{id}', [RoleController::class, 'destroy']);
    Route::post('roles/asignar-permiso', [RoleController::class, 'asignarPermiso']);

    // --- PERMISOS ---
    Route::get('permisos', [PermisoController::class, 'index']);
    Route::post('permisos', [PermisoController::class, 'store']);
    Route::get('permisos/{id}', [PermisoController::class, 'show']);
    Route::put('permisos/{id}', [PermisoController::class, 'update']);
    Route::delete('permisos/{id}', [PermisoController::class, 'destroy']);

    // --- COMIDAS ---
    Route::get('comida', [ComidaController::class, 'index']);
    Route::post('comida', [ComidaController::class, 'store']);
    Route::get('comida/{id}', [ComidaController::class, 'show']);
    Route::put('comida/{id}', [ComidaController::class, 'update']);
    Route::delete('comida/{id}', [ComidaController::class, 'destroy']);

    // --- BECAS ---
    Route::get('becas', [BecaController::class, 'index']);
    Route::post('becas', [BecaController::class, 'store']);
    Route::get('becas/{id}', [BecaController::class, 'show']);
    Route::put('becas/{id}', [BecaController::class, 'update']);
    Route::delete('becas/{id}', [BecaController::class, 'destroy']);

    // --- ESTADOS BECA ---
    Route::get('estado-beca', [EstadoBecaController::class, 'index']);
    Route::post('estado-beca', [EstadoBecaController::class, 'store']);
    Route::get('estado-beca/{id}', [EstadoBecaController::class, 'show']);
    Route::put('estado-beca/{id}', [EstadoBecaController::class, 'update']);
    Route::delete('estado-beca/{id}', [EstadoBecaController::class, 'destroy']);
    Route::get('/becas/usuario/{userId}', [BecaController::class, 'getByUserId']);

    // --- RESERVAS ---
    Route::get('reserva', [ReservaController::class, 'index']);
    Route::post('reserva', [ReservaController::class, 'store']);
    Route::get('reserva/{id}', [ReservaController::class, 'show']);
    Route::put('reserva/{id}', [ReservaController::class, 'update']); // Para cancelar
    Route::post('reservas/verificar-qr', [ReservaController::class, 'verificarQR']);
    Route::get('/reservas/codigo-del-dia/{id}', [ReservaController::class, 'buscarCodigoReservasDelDiayComida']);

    // --- ESTADOS RESERVA ---
    Route::get('estado-reserva', [EstadoReservaController::class, 'index']);
    Route::post('estado-reserva', [EstadoReservaController::class, 'store']);
    Route::get('estado-reserva/{id}', [EstadoReservaController::class, 'show']);
    Route::put('estado-reserva/{id}', [EstadoReservaController::class, 'update']);
    Route::delete('estado-reserva/{id}', [EstadoReservaController::class, 'destroy']);

    // --- HORARIOS ---
    Route::get('horario', [HorarioController::class, 'index']);
    Route::post('horario', [HorarioController::class, 'store']);
    Route::get('horario/{id}', [HorarioController::class, 'show']);
    Route::put('horario/{id}', [HorarioController::class, 'update']);
    Route::delete('horario/{id}', [HorarioController::class, 'destroy']);

    // --- REPORTES ---
    Route::get('inasistencias', [ReporteController::class, 'estudiantesConInasistencias']);
    Route::get('trafico', [ReporteController::class, 'traficoRestaurante']);
    Route::get('becados/{id}/faltas', [ReporteController::class, 'faltasBecado']);

});