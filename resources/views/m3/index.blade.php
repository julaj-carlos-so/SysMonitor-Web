<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simulador CPU - Módulo 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4">Módulo 3: Planificación de CPU (FCFS)</h2>
        <div class="row">
            <!-- Formulario de Configuración -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Configurar</div>
                    <div class="card-body">
                        <form action="/m3-simulador" method="POST">
                            @csrf
                            <label class="form-label fw-bold">Algoritmo</label>
<select name="algoritmo" class="form-select mb-3">
    <option value="FCFS">FCFS (First Come, First Serve)</option>
    <option value="SJF">SJF (Shortest Job First - No expropiativo)</option>
</select>
                            <h5 class="mb-3">Procesos</h5>
                            @for($i = 0; $i < 3; $i++)
                            <div class="row mb-2">
                                <div class="col-4"><input type="text" name="procesos[{{$i}}][nombre]" class="form-control" value="P{{$i+1}}" readonly></div>
                                <div class="col-4"><input type="number" name="procesos[{{$i}}][llegada]" class="form-control" placeholder="Llegada" required></div>
                                <div class="col-4"><input type="number" name="procesos[{{$i}}][rafaga]" class="form-control" placeholder="Ráfaga" required></div>
                            </div>
                            @endfor
                            <button type="submit" class="btn btn-success w-100 mt-3">Simular</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resultados y Diagrama de Gantt -->
            <div class="col-md-8">
                @if(isset($procesos))
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Resultados: {{ $algoritmo }}</div>
                    <div class="card-body">
                        <h5 class="mb-3">Diagrama de Gantt</h5>
                        <div class="d-flex mb-4 text-center" style="height: 50px; border: 1px solid #ccc; width: 100%;">
                            @foreach($gantt as $bloque)
                                <div class="d-flex align-items-center justify-content-center text-white bg-info border-end" 
                                     style="flex: {{ $bloque['ancho'] }};" 
                                     title="Inicio: {{ $bloque['inicio'] }} | Fin: {{ $bloque['fin'] }}">
                                    <strong>{{ $bloque['nombre'] }}</strong>
                                </div>
                            @endforeach
                        </div>

                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr><th>Proceso</th><th>Llegada</th><th>Ráfaga</th><th>Espera</th><th>Retorno</th></tr>
                            </thead>
                            <tbody>
                                @foreach($procesos as $p)
                                <tr>
                                    <td>{{ $p['nombre'] }}</td><td>{{ $p['llegada'] }}</td><td>{{ $p['rafaga'] }}</td>
                                    <td>{{ $p['espera'] }}</td><td>{{ $p['retorno'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr><th colspan="3" class="text-end">Promedios:</th><th>{{ number_format($esperaPromedio, 2) }}</th><th>{{ number_format($retornoPromedio, 2) }}</th></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @else
                <div class="alert alert-info">Ingresa los tiempos de llegada y ráfaga (ej. 1, 3, 5) y presiona Simular.</div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
