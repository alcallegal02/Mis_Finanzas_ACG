<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'middleware' => 'api', // Asegura que las rutas usen la configuración 'api'
    'prefix' => 'auth'     // Prefijo para las rutas de autenticación (ej: /api/auth/login)
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']); // Cambiado a GET para obtener info del usuario
});

// Aquí irán las rutas para el CRUD de finanzas

Route::apiResource('transactions', App\Http\Controllers\API\TransactionController::class)
    ->middleware('auth:api'); // Aplica el middleware aquí o en el constructor del controlador