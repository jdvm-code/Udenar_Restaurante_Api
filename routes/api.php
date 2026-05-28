<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\EstadoAsistenciaController;
use App\Http\Controllers\PermisoController;
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

//rutas protegidas por autenticacion
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', [AuthController::class, 'me']);

});

//rutas de recursos
Route::apiResource('comida', ComidaController::class);
Route::apiResource('asistencia', AsistenciaController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('permisos', PermisoController::class);
Route::apiResource('estado-asistencia', EstadoAsistenciaController::class);










