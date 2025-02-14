<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngresoController;

// Redirigir la raíz ("/") a ingresos
Route::get('/', function () {
    return redirect('/ingresos');
});

// Ruta para ingresos
Route::get('/ingresos', [IngresoController::class, 'index']);

// Manejar rutas inexistentes y redirigir a ingresos
Route::fallback(function () {
    return redirect('/ingresos');
});
