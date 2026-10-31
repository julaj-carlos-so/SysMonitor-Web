@extends('layouts.app')

@section('title', 'Dashboard - SysMonitor Web')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Panel principal</h2>
    <p class="text-muted">
        Bienvenido a SysMonitor Web. Aquí puedes consultar los módulos de monitoreo del sistema.
    </p>
</div>

<div class="row g-4">

    <!-- Módulo 1 -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-primary">Módulo 1</span>
                    <span class="text-primary fs-3">⚙</span>
                </div>

                <h5 class="card-title fw-bold">Gestión de procesos</h5>

                <p class="text-muted">
                    Consulta los procesos del sistema, revisa su estado y administra los procesos de prueba.
                </p>

                <a href="{{ url('/m1-procesos') }}" class="btn btn-primary">
                    Abrir módulo
                </a>
            </div>
        </div>
    </div>

    <!-- Módulo 2 -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-success">Módulo 2</span>
                    <span class="text-success fs-3">📊</span>
                </div>

                <h5 class="card-title fw-bold">CPU y memoria</h5>

                <p class="text-muted">
                    Visualiza información del uso del procesador y la memoria del sistema mediante gráficos.
                </p>

                <a href="{{ url('/modulo2') }}" class="btn btn-success">
                    Abrir módulo
                </a>
            </div>
        </div>
    </div>

    <!-- Módulo 3 -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-warning text-dark">Módulo 3</span>
                    <span class="text-warning fs-3">🔄</span>
                </div>

                <h5 class="card-title fw-bold">Planificación de CPU</h5>

                <p class="text-muted">
                    Simula algoritmos de planificación y analiza cómo se ejecutan los procesos.
                </p>

                <a href="{{ url('/m3-simulador') }}" class="btn btn-warning">
                    Abrir módulo
                </a>
            </div>
        </div>
    </div>

    <!-- Módulo 5 -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-secondary">Módulo 5</span>
                    <span class="text-secondary fs-3">💾</span>
                </div>

                <h5 class="card-title fw-bold">Almacenamiento</h5>

                <p class="text-muted">
                    Consulta información relacionada con el almacenamiento del sistema.
                </p>

                <button class="btn btn-secondary" disabled>
                    En desarrollo
                </button>
            </div>
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body">
        <h5 class="fw-bold">Información del proyecto</h5>
        <p class="text-muted mb-1">
            SysMonitor Web - Monitor y Administrador Web del Sistema Operativo.
        </p>
        <small class="text-muted">
            Sistemas Operativos 1 | Universidad Mariano Gálvez de Guatemala
        </small>
    </div>
</div>

@endsection

