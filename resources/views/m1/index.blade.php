@extends('layouts.app')

@section('title', 'M1 - Procesos')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Módulo 1: Listado de Procesos</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>PID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>PPID</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procesos as $proceso)
                <tr>
                    <td>{{ $proceso['pid'] }}</td>
                    <td>{{ $proceso['nombre'] }}</td>
                    <td>
                        @if($proceso['estado'] == 'R') <span class="badge bg-success">En ejecución (R)</span>
                        @elseif($proceso['estado'] == 'S') <span class="badge bg-info">Durmiendo (S)</span>
                        @else <span class="badge bg-secondary">{{ $proceso['estado'] }}</span>
                        @endif
                    </td>
                    <td>{{ $proceso['ppid'] }}</td>
                    <td>
                        <form action="{{ route('procesos.senal') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="pid" value="{{ $proceso['pid'] }}">
                            <input type="hidden" name="senal" value="15">
                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Seguro que deseas enviar SIGTERM a este proceso?');">
                                Terminar (15)
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
