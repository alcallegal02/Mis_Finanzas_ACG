<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\TransactionController; // Asegúrate que este 'use' statement esté


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTAS PARA TRANSACCIONES WEB ---
    // Mostrar formulario para crear nueva transacción
    Route::get('/transactions/create', [TransactionController::class, 'create'])
        ->name('web.transactions.create');

    // Guardar nueva transacción
    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('web.transactions.store');

    // Mostrar formulario para editar transacción existente
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
        ->name('web.transactions.edit');

    // Actualizar transacción existente
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
        ->name('web.transactions.update');

    // Eliminar transacción existente
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
        ->name('web.transactions.destroy');
});

require __DIR__.'/auth.php';