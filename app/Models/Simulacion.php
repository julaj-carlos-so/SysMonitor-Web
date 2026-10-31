<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulacion extends Model
{
    protected $fillable = [
        'algoritmo',
        'detalle_procesos',
        'espera_promedio',
        'retorno_promedio'
    ];
}
