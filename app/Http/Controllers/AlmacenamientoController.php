<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlmacenamientoController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener información de discos y particiones en JSON
        $lsblkJson = shell_exec('lsblk -J');
        $discos = json_decode($lsblkJson, true);

        // 2. Obtener espacio en disco accesible para humanos
        $espacio = shell_exec('df -h');

        // 3. Leer usuarios del sistema desde /etc/passwd
        $usuariosRaw = file_exists('/etc/passwd') ? file('/etc/passwd') : [];
        $usuarios = [];
        foreach ($usuariosRaw as $linea) {
            $datos = explode(':', $linea);
            if (isset($datos[0])) {
                $usuarios[] = [
                    'nombre' => $datos[0],
                    'uid' => $datos[2] ?? '',
                    'home' => $datos[5] ?? ''
                ];
            }
        }

        // 4. Explorador de archivos restringido y seguro
        $basePath = storage_path('app');
        $subpath = $request->get('path', '');
        
        $targetPath = realpath($basePath . '/' . $subpath);

        // Prevención de salto de directorio (Directory Traversal)
        if (!$targetPath || strpos($targetPath, $basePath) !== 0) {
            $targetPath = $basePath;
            $subpath = '';
        }

        $archivos = [];
        if (is_dir($targetPath)) {
            $items = scandir($targetPath);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                $fullItemPath = $targetPath . '/' . $item;
                $archivos[] = [
                    'nombre' => $item,
                    'es_directorio' => is_dir($fullItemPath),
                    'tamano' => is_file($fullItemPath) ? filesize($fullItemPath) : '-',
                    'rel_path' => trim($subpath . '/' . $item, '/')
                ];
            }
        }

        return view('m5.index', compact('discos', 'espacio', 'usuarios', 'archivos', 'subpath'));
    }
}
