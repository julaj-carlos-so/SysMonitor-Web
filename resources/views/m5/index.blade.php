<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M5 - Almacenamiento y Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h1 class="mb-4 text-primary">Módulo 5: Almacenamiento y Sistema de Archivos</h1>
        
        <!-- Tarjeta de Espacio Libre (df -h) -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white font-weight-bold">Espacio en Disco (df -h)</div>
            <div class="card-body">
                <pre class="bg-secondary text-white p-3 rounded">{{ $espacio }}</pre>
            </div>
        </div>

        <!-- Tarjeta de Usuarios (/etc/passwd) -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white font-weight-bold">Usuarios del Sistema (/etc/passwd)</div>
            <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>UID</th>
                            <th>Home</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                        <tr>
                            <td>{{ $user['nombre'] }}</td>
                            <td>{{ $user['uid'] }}</td>
                            <td>{{ $user['home'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Explorador de Archivos Restringido -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white font-weight-bold">Explorador de Archivos Restringido (storage/app)</div>
            <div class="card-body">
                <p><strong>Ruta actual:</strong> /storage/app/{{ $subpath }}</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Tamaño (Bytes)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archivos as $archivo)
                        <tr>
                            <td>
                                @if($archivo['es_directorio'])
                                    <a href="?path={{ $archivo['rel_path'] }}" class="fw-bold text-decoration-none">📁 {{ $archivo['nombre'] }}</a>
                                @else
                                    📄 {{ $archivo['nombre'] }}
                                @endif
                            </td>
                            <td>{{ $archivo['es_directorio'] ? 'Carpeta' : 'Archivo' }}</td>
                            <td>{{ $archivo['tamano'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">La carpeta está vacía.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
