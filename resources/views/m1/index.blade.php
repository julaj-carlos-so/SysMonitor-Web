@extends('layouts.app')

@section('title', 'M1 - Procesos')

@section('content')
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Módulo 1: Monitoreo y Administración de Procesos</h5>
    </div>
    <div class="card-body">
        
        <!-- RESUMEN DE ESTADOS DE PROCESOS (Requerimiento del enunciado) -->
        <div class="row text-center mb-4">
            <div class="col">
                <div class="p-3 border bg-light rounded">
                    <h6>Ejecución (R)</h6>
                    <span class="fs-4 fw-bold text-success">{{ $estadisticas['R'] }}</span>
                </div>
            </div>
            <div class="col">
                <div class="p-3 border bg-light rounded">
                    <h6>Durmiendo (S)</h6>
                    <span class="fs-4 fw-bold text-info">{{ $estadisticas['S'] }}</span>
                </div>
            </div>
            <div class="col">
                <div class="p-3 border bg-light rounded">
                    <h6>Suspendido (D)</h6>
                    <span class="fs-4 fw-bold text-warning">{{ $estadisticas['D'] }}</span>
                </div>
            </div>
            <div class="col">
                <div class="p-3 border bg-light rounded">
                    <h6>Zombie (Z)</h6>
                    <span class="fs-4 fw-bold text-danger">{{ $estadisticas['Z'] }}</span>
                </div>
            </div>
            <div class="col">
                <div class="p-3 border bg-light rounded">
                    <h6>Detenido (T)</h6>
                    <span class="fs-4 fw-bold text-secondary">{{ $estadisticas['T'] }}</span>
                </div>
            </div>
        </div>

        <!-- BOTÓN PARA LANZAR PROCESO DE PRUEBA -->
        <div class="mb-3">
            <form action="{{ route('procesos.lanzar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">➕ Lanzar Proceso de Prueba (sleep 300)</button>
            </form>
        </div>

        <!-- TABLA DE PROCESOS -->
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>PID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>PPID</th>
                    <th>Acciones Seguras</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procesos as $proceso)
                <tr>
                    <td><strong>{{ $proceso['pid'] }}</strong></td>
                    <td>{{ $proceso['nombre'] }}</td>
                    <td>
                        @if($proceso['estado'] == 'R') <span class="badge bg-success">Ejecución (R)</span>
                        @elseif($proceso['estado'] == 'S') <span class="badge bg-info">Durmiendo (S)</span>
                        @elseif($proceso['estado'] == 'Z') <span class="badge bg-danger">Zombie (Z)</span>
                        @else <span class="badge bg-secondary">{{ $proceso['estado'] }}</span>
                        @endif
                    </td>
                    <td>{{ $proceso['ppid'] }}</td>
                    <td>
                        <!-- Botón Terminar suave (SIGTERM - 15) -->
                        <form action="{{ route('procesos.senal') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="pid" value="{{ $proceso['pid'] }}">
                            <input type="hidden" name="senal" value="15">
                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Enviar SIGTERM al PID {{ $proceso['pid'] }}?');">
                                Terminar (15)
                            </button>
                        </form>

                        <!-- Botón Forzar cierre (SIGKILL - 9) -->
                        <form action="{{ route('procesos.senal') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="pid" value="{{ $proceso['pid'] }}">
                            <input type="hidden" name="senal" value="9">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¡ADVERTENCIA! ¿Forzar cierre con SIGKILL al PID {{ $proceso['pid'] }}?');">
                                Forzar (9)
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
