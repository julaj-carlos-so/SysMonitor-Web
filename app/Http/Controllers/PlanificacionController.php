<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Simulacion;

class PlanificacionController extends Controller
{
    public function index()
    {
        return view('m3.index');
    }

    public function simular(Request $request)
    {
        $procesos = $request->procesos;
        $algoritmo = $request->algoritmo;
        $gantt = [];
        
        // Lógica FCFS
        if ($algoritmo === 'FCFS') {
            // Ordenar por tiempo de llegada
            usort($procesos, fn($a, $b) => $a['llegada'] <=> $b['llegada']);
            
            $tiempoActual = 0;
            
            foreach ($procesos as &$p) {
                if ($tiempoActual < $p['llegada']) {
                    $tiempoActual = $p['llegada'];
                }
                
                $inicio = $tiempoActual;
                $tiempoActual += $p['rafaga']; 
                $fin = $tiempoActual;
                
                $p['espera'] = $inicio - $p['llegada'];
                $p['retorno'] = $fin - $p['llegada'];
                
                $gantt[] = [
                    'nombre' => $p['nombre'],
                    'inicio' => $inicio,
                    'fin' => $fin,
                    'ancho' => $p['rafaga'] 
                ];
            }
        }

        $esperaPromedio = collect($procesos)->avg('espera');
        $retornoPromedio = collect($procesos)->avg('retorno');

        // Guardar en Base de Datos
        Simulacion::create([
            'algoritmo' => $algoritmo,
            'detalle_procesos' => json_encode($procesos),
            'espera_promedio' => $esperaPromedio,
            'retorno_promedio' => $retornoPromedio
        ]);

        return view('m3.index', compact('procesos', 'gantt', 'esperaPromedio', 'retornoPromedio', 'algoritmo'));
    }
}
