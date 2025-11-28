<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reportes | Sistema de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%); min-height: 100vh;">
    <x-navbar />
    
    <div class="container-fluid py-4">
        <!-- HEADER -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="text-white mb-2" style="font-weight: 700; font-size: 2.5rem;">
                            <i class="fas fa-chart-line me-3" style="color: #1cc88a;"></i>Reportes de Tickets
                        </h1>
                        <p class="text-white-50">Análisis detallado y generación de reportes en PDF</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="border: none; border-radius: 15px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="color: #4e73df; font-weight: 600;">
                            <i class="fas fa-filter me-2"></i>Filtrar Reporte
                        </h5>
                        <form id="formReporte" action="{{ route('reportes.pdf') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color: #333; font-weight: 600;">Estado del Ticket</label>
                                    <select name="estatus_id" id="estatus_id" class="form-select" style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 10px 15px;" onchange="actualizarGraficos()">
                                        <option value="">Todos</option>
                                        @foreach($estatus as $e)
                                            <option value="{{ $e->id_estatus }}">{{ $e->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color: #333; font-weight: 600;">Técnico Asignado</label>
                                    <select name="auxiliar_id" id="auxiliar_id" class="form-select" style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 10px 15px;" onchange="actualizarGraficos()">
                                        <option value="">Todos</option>
                                        @foreach($auxiliares as $a)
                                            <option value="{{ $a->id_usuario }}">{{ $a->nombre }} {{ $a->apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label" style="color: #333; font-weight: 600;">Departamento</label>
                                    <select name="departamento_id" id="departamento_id" class="form-select" style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 10px 15px;" onchange="actualizarGraficos()">
                                        <option value="">Todos</option>
                                        @foreach($departamentos as $d)
                                            <option value="{{ $d->id_departamento }}">{{ $d->nombre_departamento }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6 d-flex gap-2 align-items-end">
                                    <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%); color: white; border: none; border-radius: 10px; font-weight: 600; padding: 10px 15px;">
                                        <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary w-100" style="border-radius: 10px; border: 2px solid #ddd; font-weight: 600;" onclick="limpiarFiltros()">
                                        <i class="fas fa-redo me-2"></i>Limpiar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ESTADÍSTICAS PRINCIPALES -->
        <div class="row mb-4 g-3">
            <div class="col-lg-3 col-md-6">
                <div class="card" style="border: none; border-radius: 15px; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,245,255,0.95) 100%); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border-left: 5px solid #4e73df;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-weight: 600;">Total de Tickets</h6>
                                <h2 id="totalTickets" style="color: #4e73df; font-weight: 700;">0</h2>
                            </div>
                            <i class="fas fa-ticket-alt" style="font-size: 3rem; color: rgba(78, 115, 223, 0.2);"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card" style="border: none; border-radius: 15px; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,245,255,0.95) 100%); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border-left: 5px solid #1cc88a;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-weight: 600;">Tiempo Promedio</h6>
                                <h2 id="tiempoPromedio" style="color: #1cc88a; font-weight: 700;">0d</h2>
                            </div>
                            <i class="fas fa-hourglass-end" style="font-size: 3rem; color: rgba(28, 200, 138, 0.2);"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card" style="border: none; border-radius: 15px; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,245,255,0.95) 100%); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border-left: 5px solid #4e73df;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-weight: 600;">Técnicos Activos</h6>
                                <h2 id="auxiliaresActivos" style="color: #4e73df; font-weight: 700;">0</h2>
                            </div>
                            <i class="fas fa-users" style="font-size: 3rem; color: rgba(78, 115, 223, 0.2);"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card" style="border: none; border-radius: 15px; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,245,255,0.95) 100%); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border-left: 5px solid #1cc88a;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-weight: 600;">Departamentos</h6>
                                <h2 id="departamentosActivos" style="color: #1cc88a; font-weight: 700;">0</h2>
                            </div>
                            <i class="fas fa-building" style="font-size: 3rem; color: rgba(28, 200, 138, 0.2);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRÁFICOS -->
        <div class="row mb-4 g-3">
            <!-- Gráfico por Estatus -->
            <div class="col-lg-6">
                <div class="card" style="border: none; border-radius: 15px; background: rgba(255,255,255,0.95); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
                            <i class="fas fa-chart-doughnut me-2" style="color: #4e73df;"></i>Distribución por Estado
                        </h5>
                        <canvas id="chartEstatus" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico por Auxiliar -->
            <div class="col-lg-6">
                <div class="card" style="border: none; border-radius: 15px; background: rgba(255,255,255,0.95); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
                            <i class="fas fa-chart-bar me-2" style="color: #1cc88a;"></i>Tickets por Técnico
                        </h5>
                        <canvas id="chartAuxiliar" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico por Departamento -->
            <div class="col-lg-6">
                <div class="card" style="border: none; border-radius: 15px; background: rgba(255,255,255,0.95); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
                            <i class="fas fa-chart-bar me-2" style="color: #4e73df;"></i>Tickets por Departamento
                        </h5>
                        <canvas id="chartDepartamento" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Evolución Temporal -->
            <div class="col-lg-6">
                <div class="card" style="border: none; border-radius: 15px; background: rgba(255,255,255,0.95); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
                            <i class="fas fa-chart-line me-2" style="color: #1cc88a;"></i>Evolución Temporal
                        </h5>
                        <canvas id="chartTiempo" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLA DE DETALLES -->
        <div class="row">
            <div class="col-12">
                <div class="card" style="border: none; border-radius: 15px; background: rgba(255,255,255,0.95); box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 style="color: #333; font-weight: 600; margin-bottom: 20px;">
                            <i class="fas fa-list me-2" style="color: #4e73df;"></i>Detalle de Tickets
                        </h5>
                        <div class="table-responsive">
                            <table class="table" id="tablaTickets" style="margin: 0;">
                                <thead style="background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%); color: white;">
                                    <tr>
                                        <th style="border: none; font-weight: 600;">ID</th>
                                        <th style="border: none; font-weight: 600;">Descripción</th>
                                        <th style="border: none; font-weight: 600;">Técnico</th>
                                        <th style="border: none; font-weight: 600;">Departamento</th>
                                        <th style="border: none; font-weight: 600;">Estado</th>
                                        <th style="border: none; font-weight: 600;">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tickets as $t)
                                        <tr style="border-bottom: 1px solid #e0e0e0;">
                                            <td><span class="badge" style="background: #4e73df;">#{{ $t->id_ticket }}</span></td>
                                            <td>{{ substr($t->descripcion, 0, 50) }}...</td>
                                            <td>{{ $t->auxiliar->nombre ?? 'N/A' }}</td>
                                            <td>{{ $t->departamento->nombre_departamento ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $statusColor = match($t->estatus->nombre ?? '') {
                                                        'pendiente' => '#ff6b6b',
                                                        'proceso' => '#ffa502',
                                                        'resuelto' => '#1cc88a',
                                                        'cancelado' => '#999',
                                                        default => '#4e73df'
                                                    };
                                                @endphp
                                                <span class="badge" style="background: {{ $statusColor }};">{{ $t->estatus->nombre ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($t->fecha_creacion)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5" style="color: #999;">
                                                <i class="fas fa-inbox" style="font-size: 2rem;"></i><br>
                                                No hay tickets con los filtros aplicados
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartEstatus, chartAuxiliar, chartDepartamento, chartTiempo;

        // Colores personalizados del proyecto
        const COLORES = ['#4e73df', '#1cc88a', '#36a9e1', '#f6c23e', '#e74c3c', '#9b59b6', '#1abc9c', '#34495e'];

        function limpiarFiltros() {
            document.getElementById('estatus_id').value = '';
            document.getElementById('auxiliar_id').value = '';
            document.getElementById('departamento_id').value = '';
            actualizarGraficos();
        }

        function actualizarGraficos() {
            const estatus_id = document.getElementById('estatus_id').value;
            const auxiliar_id = document.getElementById('auxiliar_id').value;
            const departamento_id = document.getElementById('departamento_id').value;

            fetch("{{ route('reportes.estadisticas') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    estatus_id,
                    auxiliar_id,
                    departamento_id
                })
            })
            .then(response => response.json())
            .then(data => {
                actualizarEstadisticas(data);
                dibujarGraficos(data);
            })
            .catch(error => console.error('Error:', error));
        }

        function actualizarEstadisticas(data) {
            document.getElementById('totalTickets').textContent = data.estadisticas.total;
            document.getElementById('tiempoPromedio').textContent = data.estadisticas.tiempo_promedio + 'd';
            document.getElementById('auxiliaresActivos').textContent = Object.keys(data.estadisticas.por_auxiliar).length;
            document.getElementById('departamentosActivos').textContent = Object.keys(data.estadisticas.por_departamento).length;
        }

        function dibujarGraficos(data) {
            const est = data.estadisticas;

            // Gráfico Estatus (Doughnut)
            if (chartEstatus) chartEstatus.destroy();
            chartEstatus = new Chart(document.getElementById('chartEstatus'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(est.por_estatus),
                    datasets: [{
                        data: Object.values(est.por_estatus),
                        backgroundColor: COLORES,
                        borderColor: '#fff',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: { font: { size: 12, weight: '600' }, padding: 20 }
                        }
                    }
                }
            });

            // Gráfico Auxiliar (Barras)
            if (chartAuxiliar) chartAuxiliar.destroy();
            chartAuxiliar = new Chart(document.getElementById('chartAuxiliar'), {
                type: 'bar',
                data: {
                    labels: Object.keys(est.por_auxiliar),
                    datasets: [{
                        label: 'Tickets',
                        data: Object.values(est.por_auxiliar),
                        backgroundColor: '#1cc88a',
                        borderColor: '#168c70',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, labels: { font: { weight: '600' } } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
                    }
                }
            });

            // Gráfico Departamento (Barras)
            if (chartDepartamento) chartDepartamento.destroy();
            chartDepartamento = new Chart(document.getElementById('chartDepartamento'), {
                type: 'bar',
                data: {
                    labels: Object.keys(est.por_departamento),
                    datasets: [{
                        label: 'Tickets',
                        data: Object.values(est.por_departamento),
                        backgroundColor: '#4e73df',
                        borderColor: '#375eb8',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, labels: { font: { weight: '600' } } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
                    }
                }
            });

            // Gráfico Línea (Evolución)
            if (chartTiempo) chartTiempo.destroy();
            chartTiempo = new Chart(document.getElementById('chartTiempo'), {
                type: 'line',
                data: {
                    labels: Object.keys(data.evolucion),
                    datasets: [{
                        label: 'Tickets Creados',
                        data: Object.values(data.evolucion),
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, labels: { font: { weight: '600' } } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } }
                    }
                }
            });
        }

        window.addEventListener('DOMContentLoaded', actualizarGraficos);
    </script>
</body>
</html>
