<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\PlanificacionController;

// Rutas de Nelson (M3)
Route::get('/m3-simulador', [PlanificacionController::class, 'index']);
Route::post('/m3-simulador', [PlanificacionController::class, 'simular']);
