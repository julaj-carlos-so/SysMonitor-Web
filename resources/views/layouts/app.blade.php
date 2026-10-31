<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SysMonitor Web')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #172554;
            color: white;
        }

        .sidebar .brand {
            padding: 24px 18px;
            font-size: 21px;
            font-weight: bold;
            border-bottom: 1px solid #334155;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 13px 20px;
            transition: background-color 0.2s;
        }

        .sidebar a:hover {
            background-color: #1e3a8a;
            color: white;
        }

        .sidebar .section-title {
            color: #94a3b8;
            font-size: 11px;
            text-transform: uppercase;
            padding: 22px 20px 8px;
        }

        .topbar {
            background-color: white;
            padding: 17px 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .main-content {
            padding: 25px;
        }

        @media (max-width: 767px) {
            .sidebar {
                min-height: auto;
            }

            .main-content {
                padding: 15px;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <aside class="col-md-3 col-lg-2 sidebar p-0">
            <div class="brand">
                SysMonitor <span class="text-info">Web</span>
            </div>

            <nav>
                <div class="section-title">Principal</div>

                <a href="{{ url('/') }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>

                <div class="section-title">Módulos</div>

                <a href="{{ url('/m1-procesos') }}">
                    Gestión de procesos
                </a>

                <a href="{{ url('/modulo2') }}">
                    CPU y memoria
                </a>

                <a href="{{ url('/m3-simulador') }}">
                    Planificación CPU
                </a>

                <a href="#" class="text-secondary">
                    Almacenamiento (en desarrollo)
                </a>
            </nav>
        </aside>

        <div class="col-md-9 col-lg-10 p-0">

            <header class="topbar d-flex justify-content-between align-items-center">
                <div>
                    <strong>Monitor y Administrador del Sistema Operativo</strong>
                </div>

                <span class="badge bg-success">Sistema activo</span>
            </header>

            <main class="main-content">
                @yield('content')
            </main>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
