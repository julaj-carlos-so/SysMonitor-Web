<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    public function index()
    {
        $procesos = [];
        // Leer solo los directorios numéricos dentro de /proc
        $pids = glob('/proc/[0-9]*', GLOB_ONLYDIR);

        // Limitamos a los primeros 50 procesos para no sobrecargar la vista en esta prueba inicial
        foreach (array_slice($pids, 0, 50) as $pidDir) { 
            $pid = basename($pidDir);
            $statFile = "$pidDir/stat";

            if (is_readable($statFile)) {
                $content = file_get_contents($statFile);
                // Extraer mediante expresión regular: PID, Nombre, Estado y PPID
                if (preg_match('/^(\d+)\s+\((.+)\)\s+(\xB1|[A-Z])\s+(\d+)/', $content, $matches)) {
                    $procesos[] = [
                        'pid' => $matches[1],
                        'nombre' => $matches[2],
                        'estado' => $matches[3],
                        'ppid' => $matches[4],
                    ];
                }
            }
        }

        // Enviar la variable $procesos a la vista
        return view('m1.index', compact('procesos'));
    }
}
