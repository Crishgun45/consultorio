<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistorialTratamientoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TratamientoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Página de inicio (pública)
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Agrupar rutas protegidas con middleware 'auth' y 'verified'
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('pacientes', PacienteController::class);
    Route::resource('citas', CitaController::class);
    Route::resource('tratamientos', TratamientoController::class);
    Route::resource('historialtratamientos', HistorialTratamientoController::class);
});

// Incluir archivos adicionales de configuración
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
