@extends('layouts.app')
@section('title', 'M1 - Procesos')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Módulo 1: Listado de Procesos</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>PID</th><th>Nombre</th><th>Estado</th><th>PPID</th><th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procesos as $proceso)
                <tr>
                    <td>{{ $proceso['pid'] }}</td>
                    <td>{{ $proceso['nombre'] }}</td>
                    <td>{{ $proceso['estado'] }}</td>
                    <td>{{ $proceso['ppid'] }}</td>
                    <td><button class="btn btn-sm btn-danger" disabled>Mandar Señal</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
