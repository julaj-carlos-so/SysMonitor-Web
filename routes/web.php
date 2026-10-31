<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ProcesoController;

// Rutas de Carlos (M1)
Route::get('/m1-procesos', [ProcesoController::class, 'index']);
