<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// MÓDULO 2 - CPU Y MEMORIA
Route::get('/modulo2/datos', [\App\Http\Controllers\Modulo2Controller::class, 'datos'])->name('modulo2.datos');
// Página del Módulo 2 - CPU y Memoria
Route::view('/modulo2', 'modulo2')->name('modulo2.index');
