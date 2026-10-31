<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\PlanificacionController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Carlos (M1)
Route::get('/m1-procesos', [ProcesoController::class, 'index']);
Route::post('/m1-procesos/senal', [ProcesoController::class, 'enviarSenal'])->name('procesos.senal');

// Rutas de Nelson (M3)
Route::get('/m3-simulador', [PlanificacionController::class, 'index']);
Route::post('/m3-simulador', [PlanificacionController::class, 'simular']);