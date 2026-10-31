<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class Modulo2Controller extends Controller
{
    public function datos(): JsonResponse
    {
        // 1. Obtener información real de Debian 12
        $cpuInfo = file_get_contents('/proc/cpuinfo');
        $memInfo = file_get_contents('/proc/meminfo');
        $uptime = file_get_contents('/proc/uptime');
        $loadAvg = file_get_contents('/proc/loadavg');

        // 2. Obtener modelo del procesador
        preg_match('/^model name\s*:\s*(.+)$/m', $cpuInfo, $modelo);

        // 3. Contar procesadores lógicos
        $nucleosLogicos = preg_match_all(
            '/^processor\s*:/m',
            $cpuInfo
        );

        // 4. Extraer información de memoria RAM
        preg_match_all(
            '/^(\w+):\s+(\d+)\s+kB$/m',
            $memInfo,
            $filas,
            PREG_SET_ORDER
        );

        $memoria = [];

        foreach ($filas as $fila) {
            $memoria[$fila[1]] = (int) $fila[2];
        }

        // 5. Calcular memoria utilizada
        $total = $memoria['MemTotal'] ?? 0;
        $disponible = $memoria['MemAvailable'] ?? 0;
        $utilizada = max(0, $total - $disponible);

        // 6. Obtener SWAP
        $swapTotal = $memoria['SwapTotal'] ?? 0;
        $swapLibre = $memoria['SwapFree'] ?? 0;

        // 7. Tiempo encendido en segundos
        $segundos = (int) (float) explode(' ', trim($uptime))[0];

        // 8. Carga promedio del sistema
        $carga = preg_split('/\s+/', trim($loadAvg));

        // 9. Devolver datos en formato JSON
        return response()->json([
	    'uso_cpu_porcentaje' => $this->calcularUsoCpu(),

            'top_cpu' => $this->obtenerTopProcesos('cpu'),
'top_memoria' => $this->obtenerTopProcesos('ram'),
            'procesador' => $modelo[1] ?? 'Desconocido',
            'nucleos_logicos' => $nucleosLogicos,
            'tiempo_encendido' => $segundos,

            'ram_total_mb' => round($total / 1024, 2),
            'ram_utilizada_mb' => round($utilizada / 1024, 2),
            'ram_disponible_mb' => round($disponible / 1024, 2),
            'ram_cache_mb' => round(
                ($memoria['Cached'] ?? 0) / 1024, 2
            ),

            'swap_total_mb' => round($swapTotal / 1024, 2),
            'swap_utilizada_mb' => round(
    ($swapTotal - $swapLibre) / 1024, 2
),

'ram_libre_mb' => round(
    ($memoria['MemFree'] ?? 0) / 1024, 2
),

            'carga_promedio' => [
                '1_minuto' => (float) ($carga[0] ?? 0),
                '5_minutos' => (float) ($carga[1] ?? 0),
                '15_minutos' => (float) ($carga[2] ?? 0)
            ]
        ]);
    }
// Leer los tiempos de trabajo del CPU
private function leerCpu(): array
{
    $contenido = file_get_contents('/proc/stat');

    $linea = explode("\n", $contenido)[0];

    $valores = preg_split('/\s+/', trim($linea));

    array_shift($valores);

    $tiempos = array_map('intval', array_slice($valores, 0, 8));

    $total = array_sum($tiempos);

    $inactivo = $tiempos[3] + $tiempos[4];

    return [$total, $inactivo];
}

// Calcular el porcentaje de uso del CPU
private function calcularUsoCpu(): float
{
    [$total1, $inactivo1] = $this->leerCpu();

    usleep(250000);

    [$total2, $inactivo2] = $this->leerCpu();

    $diferenciaTotal = $total2 - $total1;

    $diferenciaInactivo = $inactivo2 - $inactivo1;

    if ($diferenciaTotal <= 0) {
        return 0;
    }

    $uso = 100 * (
        $diferenciaTotal - $diferenciaInactivo
    ) / $diferenciaTotal;

    return round($uso, 2);
}
// MÓDULO 2 - Obtener los 5 procesos que más recursos consumen
private function obtenerTopProcesos(string $tipo): array
{
    // Lista blanca de comandos permitidos
    $comandos = [
        'cpu' => 'ps -eo pid,pcpu,pmem,comm --sort=-pcpu --no-headers',
        'ram' => 'ps -eo pid,pcpu,pmem,comm --sort=-pmem --no-headers'
    ];

    if (!isset($comandos[$tipo])) {
        return [];
    }

    // Ejecutar únicamente comandos autorizados
    $lineas = [];
    $estado = 0;

    exec($comandos[$tipo], $lineas, $estado);

    if ($estado !== 0) {
        return [];
    }

    $procesos = [];

    // Obtener los primeros cinco procesos
    foreach ($lineas as $linea) {

        $datos = preg_split('/\s+/', trim($linea), 4);

        if (count($datos) < 4) {
            continue;
        }
	// Excluir el comando temporal ps
if (trim($datos[3]) === 'ps') {
    continue;
}

        $procesos[] = [
            'pid' => (int) $datos[0],
            'cpu' => (float) $datos[1],
            'ram' => (float) $datos[2],
            'nombre' => $datos[3]
        ];
// Detener cuando tengamos cinco procesos
if (count($procesos) >= 5) {
    break;
}
    }

    return $procesos;
}
}
