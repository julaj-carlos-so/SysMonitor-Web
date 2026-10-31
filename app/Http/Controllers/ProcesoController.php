<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    public function index()
    {
        $procesos = [];
        $pids = glob('/proc/[0-9]*', GLOB_ONLYDIR);

        foreach (array_slice($pids, 0, 50) as $pidDir) { 
            $pid = basename($pidDir);
            $statFile = "$pidDir/stat";

            if (is_readable($statFile)) {
                $content = file_get_contents($statFile);
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
        return view('m1.index', compact('procesos'));
    }
}
