<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\EstadoAsistenciaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', [AuthController::class, 'me']);

});

Route::apiResource('comida', ComidaController::class);
Route::apiResource('asistencia', AsistenciaController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('permisos', PermisoController::class);
Route::apiResource('estado-asistencia', EstadoAsistenciaController::class);










