<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', [AuthController::class, 'me']);

/*     Route::api('/tareas', [TareaController::class, 'index']);
    Route::api('/tareas', [TareaController::class, 'store']);
    Route::api('/tareas', [TareaController::class, 'show']);
    Route::api('/tareas', [TareaController::class, 'update']);
    Route::api('/tareas', [TareaController::class, 'destroy']);
 */
});










