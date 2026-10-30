<!DOCTYPE html>
<html lang="es">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Módulo 2 - CPU y Memoria</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 25px;
        }

        h1 {
            color: #172554;
            text-align: center;
        }

        .contenedor {
            display: grid;
            grid-template-columns: repeat(
                auto-fit, minmax(240px, 1fr)
            );
            gap: 20px;
            margin-top: 30px;
        }

        .tarjeta {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px #00000015;
            text-align: center;
        }

        .tarjeta h2 {
            color: #1e40af;
        }

        .valor {
            font-size: 35px;
            font-weight: bold;
            color: #059669;
        }

        .detalle {
            color: #475569;
            margin-top: 12px;
            overflow-wrap: anywhere;
        }
     .tabla-procesos {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 14px;
}

.tabla-procesos th {
    background: #1e40af;
    color: white;
    padding: 12px;
    text-align: center;
}

.tabla-procesos td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.tabla-procesos tr:hover {
    background: #eff6ff;
}
    </style>
</head>

<body>

    <h1>SYSMONITOR WEB</h1>

    <h2 style="text-align:center">
        Módulo 2 - CPU y Memoria
    </h2>

    <div class="contenedor">

        <!-- PROCESADOR -->
        <div class="tarjeta">
            <h2>🖥️ CPU</h2>

            <p class="valor" id="cpu">0%</p>

            <p class="detalle" id="procesador">
                Cargando...
            </p>

            <p id="nucleos"></p>
        </div>

        <!-- MEMORIA RAM -->
        <div class="tarjeta">
            <h2>💾 Memoria RAM</h2>

            <p class="valor" id="ram">0%</p>

            <p id="ramTotal"></p>

            <p id="ramUtilizada"></p>

            <p id="ramDisponible"></p>
        </div>

        <!-- MEMORIA SWAP -->
        <div class="tarjeta">
            <h2>📦 Memoria SWAP</h2>

            <p class="valor" id="swap">0%</p>

            <p id="swapTotal"></p>

            <p id="swapUtilizada"></p>
        </div>

    </div>
<h2 style="text-align:center; margin-top:40px;">
    Monitoreo en tiempo real
</h2>

<div class="contenedor">

    <div class="tarjeta">
        <h2>📈 Uso del CPU</h2>
        <canvas id="graficaCPU"></canvas>
    </div>

    <div class="tarjeta">
        <h2>📈 Uso de memoria RAM</h2>
        <canvas id="graficaRAM"></canvas>
    </div>

</div>
<!-- TOP 5 PROCESOS -->
<h2 style="text-align:center; margin-top:40px;">
    Procesos que consumen más recursos
</h2>

<div class="contenedor">

    <!-- TABLA CPU -->
    <div class="tarjeta">
        <h2>🖥️ Top 5 - Procesos por CPU</h2>

        <div style="overflow-x:auto;">
            <table class="tabla-procesos">
                <thead>
                    <tr>
                        <th>PID</th>
                        <th>Proceso</th>
                        <th>CPU %</th>
                        <th>RAM %</th>
                    </tr>
                </thead>

                <tbody id="tablaTopCPU">
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABLA MEMORIA -->
    <div class="tarjeta">
        <h2>💾 Top 5 - Procesos por RAM</h2>

        <div style="overflow-x:auto;">
            <table class="tabla-procesos">
                <thead>
                    <tr>
                        <th>PID</th>
                        <th>Proceso</th>
                        <th>CPU %</th>
                        <th>RAM %</th>
                    </tr>
                </thead>

                <tbody id="tablaTopRAM">
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- INFORMACIÓN ADICIONAL DEL SISTEMA -->

<h2 style="text-align:center; margin-top:40px;">
    Información general del sistema
</h2>

<div class="contenedor">

    <!-- TIEMPO ENCENDIDO -->
    <div class="tarjeta">

        <h2>⏱️ Tiempo encendido</h2>

        <p class="valor" id="tiempoEncendido">
            Cargando...
        </p>

        <p class="detalle">
            Tiempo de actividad de Debian 12
        </p>

    </div>

    <!-- CARGA PROMEDIO -->
    <div class="tarjeta">

        <h2>📊 Carga del sistema</h2>

        <p id="carga1">1 minuto: --</p>

        <p id="carga5">5 minutos: --</p>

        <p id="carga15">15 minutos: --</p>

    </div>

    <!-- MEMORIA DETALLADA -->
    <div class="tarjeta">

        <h2>💾 Detalles de memoria</h2>

        <p id="memoriaLibre">Libre: --</p>

        <p id="memoriaCache">Caché: --</p>

        <p id="memoriaDisponible">Disponible: --</p>

    </div>

</div>
    <script>
// Gráfica del CPU
const graficaCPU = new Chart(
    document.getElementById('graficaCPU'),
    {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Uso del CPU (%)',
                data: [],
                borderColor: 'blue',
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 100
                }
            }
        }
    }
);

// Gráfica de memoria RAM
const graficaRAM = new Chart(
    document.getElementById('graficaRAM'),
    {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Uso de RAM (%)',
                data: [],
                borderColor: 'green',
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    min: 0,
                    max: 100
                }
            }
        }
    }
);

// Agregar nuevas mediciones
function agregarDato(grafica, valor) {

    const hora = new Date().toLocaleTimeString();

    grafica.data.labels.push(hora);
    grafica.data.datasets[0].data.push(valor);

    // Mostrar únicamente las últimas 20 mediciones
    if (grafica.data.labels.length > 20) {
        grafica.data.labels.shift();
        grafica.data.datasets[0].data.shift();
    }

    grafica.update();
}
       // Mostrar los 5 procesos principales
function mostrarProcesos(idTabla, procesos) {

    const tabla = document.getElementById(idTabla);

    // Limpiar los datos anteriores
    tabla.replaceChildren();

    if (!Array.isArray(procesos)) {
        return;
    }

    procesos.forEach(proceso => {

        const fila = document.createElement("tr");

        const valores = [
            proceso.pid,
            proceso.nombre,
            Number(proceso.cpu).toFixed(2) + "%",
            Number(proceso.ram).toFixed(2) + "%"
        ];

        valores.forEach(valor => {

            const celda = document.createElement("td");

            celda.textContent = valor;

            fila.appendChild(celda);
        });

        tabla.appendChild(fila);
    });
}
        async function actualizarDatos() {

            try {

                const respuesta = await fetch(
                    "{{ route('modulo2.datos') }}"
                );

                if (!respuesta.ok) {
                    throw new Error("Error al obtener datos");
                }

                const datos = await respuesta.json();


              // ======================================
// TIEMPO ENCENDIDO DEL SISTEMA
// ======================================

const segundos = Number(datos.tiempo_encendido);

const dias = Math.floor(segundos / 86400);

const horas = Math.floor((segundos % 86400) / 3600);

const minutos = Math.floor((segundos % 3600) / 60);

document.getElementById("tiempoEncendido").textContent =
    dias + " días, " +
    horas + " horas y " +
    minutos + " minutos";


// ======================================
// CARGA PROMEDIO DEL SISTEMA
// ======================================

document.getElementById("carga1").textContent =
    "1 minuto: " + datos.carga_promedio["1_minuto"];

document.getElementById("carga5").textContent =
    "5 minutos: " + datos.carga_promedio["5_minutos"];

document.getElementById("carga15").textContent =
    "15 minutos: " + datos.carga_promedio["15_minutos"];


// ======================================
// INFORMACIÓN DE MEMORIA
// ======================================

document.getElementById("memoriaLibre").textContent =
    "Libre: " + datos.ram_libre_mb + " MB";

document.getElementById("memoriaCache").textContent =
    "Caché: " + datos.ram_cache_mb + " MB";

document.getElementById("memoriaDisponible").textContent =
    "Disponible: " + datos.ram_disponible_mb + " MB";
               // Actualizar las tablas de procesos
mostrarProcesos("tablaTopCPU", datos.top_cpu);

mostrarProcesos("tablaTopRAM", datos.top_memoria);

                // CPU
                document.getElementById("cpu").textContent =
                    datos.uso_cpu_porcentaje + "%";

                document.getElementById("procesador").textContent =
                    datos.procesador;

                document.getElementById("nucleos").textContent =
                    "Procesadores lógicos: " + datos.nucleos_logicos;
                // RAM
                const porcentajeRam = datos.ram_total_mb > 0
                    ? (datos.ram_utilizada_mb /
                       datos.ram_total_mb) * 100
                    : 0;

                document.getElementById("ram").textContent =
                    porcentajeRam.toFixed(2) + "%";

                document.getElementById("ramTotal").textContent =
                    "Total: " + datos.ram_total_mb + " MB";

                document.getElementById("ramUtilizada").textContent =
                    "Utilizada: " + datos.ram_utilizada_mb + " MB";

                document.getElementById("ramDisponible").textContent =
                    "Disponible: " + datos.ram_disponible_mb + " MB";

                // SWAP
                const porcentajeSwap = datos.swap_total_mb > 0
                    ? (datos.swap_utilizada_mb /
                       datos.swap_total_mb) * 100
                    : 0;

                document.getElementById("swap").textContent =
                    porcentajeSwap.toFixed(2) + "%";

                document.getElementById("swapTotal").textContent =
                    "Total: " + datos.swap_total_mb + " MB";

                document.getElementById("swapUtilizada").textContent =
                    "Utilizada: " + datos.swap_utilizada_mb + " MB";
// Actualizar gráficas con los datos reales
agregarDato(
    graficaCPU,
    Number(datos.uso_cpu_porcentaje)
);

agregarDato(
    graficaRAM,
    porcentajeRam
);
            } catch (error) {
                console.error(error);
            }
        }
	
        // Obtener datos al abrir la página
        actualizarDatos();

        // Actualizar cada 3 segundos
        setInterval(actualizarDatos, 3000);
    </script>

</body>
</html>
