<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Darvin Sinay (M5 - Almacenamiento)
use App\Http\Controllers\AlmacenamientoController;
Route::get('/m5-discos', [AlmacenamientoController::class, 'index']);
