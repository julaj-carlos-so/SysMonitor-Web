<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanificacionController;

Route::get('/', function () {
    return view('welcome');
});

// MÓDULO 2 - CPU Y MEMORIA
Route::get('/modulo2/datos', [App\Http\Controllers\Modulo2Controller::class, 'datos'])->name('modulo2.datos');
// Página del Módulo 2 - CPU y Memoria
Route::view('/modulo2', 'modulo2')->name('modulo2.index');

// Rutas de Nelson (M3)
Route::get('/m3-simulador', [PlanificacionController::class, 'index']);
Route::post('/m3-simulador', [PlanificacionController::class, 'simular']);