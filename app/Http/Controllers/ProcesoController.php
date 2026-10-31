<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    public function index()
    {
        $procesos = [];
        $estadisticas = ['R' => 0, 'S' => 0, 'D' => 0, 'Z' => 0, 'T' => 0, 'Otros' => 0];
        
        $pids = glob('/proc/[0-9]*', GLOB_ONLYDIR);

        foreach (array_slice($pids, 0, 50) as $pidDir) { 
            $pid = basename($pidDir);
            $statFile = "$pidDir/stat";

            if (is_readable($statFile)) {
                $content = file_get_contents($statFile);
                if (preg_match('/^(\d+)\s+\((.+)\)\s+(\xB1|[A-Z])\s+(\d+)/', $content, $matches)) {
                    $estado = $matches[3];
                    
                    $procesos[] = [
                        'pid' => $matches[1],
                        'nombre' => $matches[2],
                        'estado' => $estado,
                        'ppid' => $matches[4],
                    ];

                    // Contar estados para el resumen
                    if (isset($estadisticas[$estado])) {
                        $estadisticas[$estado]++;
                    } else {
                        $estadisticas['Otros']++;
                    }
                }
            }
        }

        return view('m1.index', compact('procesos', 'estadisticas'));
    }

    public function enviarSenal(Request $request)
    {
        $pid = filter_var($request->pid, FILTER_VALIDATE_INT);
        $senal = filter_var($request->senal, FILTER_VALIDATE_INT);

        $senalesPermitidas = [9, 15, 18, 19];

        if ($pid && in_array($senal, $senalesPermitidas)) {
            $safePid = escapeshellarg($pid);
            $safeSenal = escapeshellarg($senal);

            shell_exec("kill -{$safeSenal} {$safePid}");
            
            $nombreSenal = ($senal == 9) ? 'SIGKILL (9)' : 'SIGTERM (15)';
            return back()->with('success', "Señal {$nombreSenal} enviada correctamente al PID {$pid}.");
        }

        return back()->with('error', 'Acción denegada: Parámetros inválidos o señal no permitida.');
    }

    public function lanzarPrueba()
    {
        shell_exec("nohup sleep 300 > /dev/null 2>&1 &");
        return back()->with('success', '¡Proceso de prueba (sleep 300) lanzado exitosamente en segundo plano!');
    }
}
