<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Jefe de Área</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* ESTILOS CLAVE HEREDADOS DE GESTIÓN DE USUARIOS */
        body {
            background-color: #f3f6fb;
            font-family: 'Poppins', sans-serif;
        }

        .usuarios-card { 
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1200px; 
            margin: 50px auto;
        }

        .usuarios-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .usuarios-body {
            padding: 50px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }
        /* FIN ESTILOS HEREDADOS */

        /* --- ESTILOS ESPECÍFICOS DEL DASHBOARD (KDIs y Gráficos) --- */
        
        .kdi-card {
            border-left: 4px solid;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            height: 100%; 
        }
        .kdi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        .kdi-card-body {
            padding: 1.5rem;
        }
        .kdi-title {
            color: #777;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .kdi-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
        }
        .kdi-icon {
            font-size: 2.5rem;
            opacity: 0.3;
        }

        /* Colores para las tarjetas KDI */
        .border-primary { border-color: #4e73df !important; }
        .text-primary { color: #4e73df !important; }

        .border-success { border-color: #1cc88a !important; }
        .text-success { color: #1cc88a !important; }

        .border-warning { border-color: #f6c23e !important; }
        .text-warning { color: #f6c23e !important; }
        
        .border-info { border-color: #36b9cc !important; }
        .text-info { color: #36b9cc !important; }

        /* Estilo para las tarjetas grandes (Gráficos) */
        .chart-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 20px;
            height: 100%;
        }
    </style>
</head>
<body>

{{-- <x-navbar /> COMENTADO TEMPORALMENTE --}}

<div class="usuarios-card">
    
    <div class="usuarios-header">
        <h2>Dashboard de Soporte</h2>
        <p>Panel de Control para el Jefe de Área</p>
    </div>

    <div class="usuarios-body">
        <h4 class="mb-5 text-dark">Resumen Ejecutivo</h4>

        <div class="row g-4 mb-5">
            
            <div class="col-xl-3 col-md-6">
                <div class="card kdi-card border-primary">
                    <div class="card-body kdi-card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="kdi-title text-primary">Tickets Totales</div>
                                <div class="kdi-value">{{ $totalTickets }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-ticket-fill kdi-icon text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card kdi-card border-success">
                    <div class="card-body kdi-card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="kdi-title text-success">Tickets Cerrados (Mes)</div>
                                <div class="kdi-value">{{ $ticketsCerradosMes }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-check-circle-fill kdi-icon text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card kdi-card border-warning">
                    <div class="card-body kdi-card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="kdi-title text-warning">Tickets Pendientes</div>
                                <div class="kdi-value">{{ $ticketsPendientes }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-hourglass-split kdi-icon text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card kdi-card border-info">
                    <div class="card-body kdi-card-body">
                        <div class="row align-items-center">
                            <div class="col me-2">
                                <div class="kdi-title text-info">Tiempo Prom. Respuesta</div>
                                <div class="kdi-value">{{ $tiempoPromedioRespuesta }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clock-fill kdi-icon text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="chart-card">
                    <h5 class="text-primary mb-3">Rendimiento Mensual de Tickets</h5>
                    <p class="text-secondary">Tickets creados vs. cerrados por mes.</p>
                    <div style="height: 350px;">
                        <canvas id="rendimientoMensualChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-card">
                    <h5 class="text-primary mb-3">Tickets por Departamento</h5>
                    <p class="text-secondary">Distribución de la carga de trabajo actual.</p>
                    <div style="height: 350px;">
                        <canvas id="departamentosChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<footer>
    Sistema de Tickets &copy; 2023 Dulces Ricos.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- DATOS DEL CONTROLADOR (PHP) ---
        const datosRendimiento = @json($datosRendimiento);
        const datosDepartamentos = @json($datosDepartamentos);
        
        // Nombres de los meses y Colores
        const nombresMeses = [
            "Ene", "Feb", "Mar", "Abr", "May", "Jun", 
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
        ];
        
        const colores = {
            primary: 'rgba(78, 115, 223, 1)',  // Azul
            success: 'rgba(28, 200, 138, 1)', // Verde
            warning: 'rgba(246, 194, 62, 1)', // Amarillo
            info: 'rgba(54, 185, 204, 1)',    // Cyan
            danger: 'rgba(231, 74, 59, 1)',   // Rojo
            secondary: 'rgba(133, 135, 150, 1)' // Gris
        };
        
        const coloresDepartamentos = [
            colores.primary, colores.success, colores.warning, 
            colores.info, colores.danger, colores.secondary,
            '#00bcd4', '#ff9800', '#f44336', '#2196f3', '#4caf50', '#9c27b0' 
        ];


        // -------------------------------------------------------------------
        // GRÁFICO 1: RENDIMIENTO MENSUAL (AMBOS BARRAS AGRUPADAS)
        // -------------------------------------------------------------------

        const ctxRendimiento = document.getElementById('rendimientoMensualChart');
        if (ctxRendimiento) {
            
            // Mapear los datos del array corregido
            const labelsRendimiento = datosRendimiento.map(item => `${nombresMeses[item.mes - 1]} ${item.anio % 100}`);
            const dataCreados = datosRendimiento.map(item => item.creados);
            const dataCerrados = datosRendimiento.map(item => item.cerrados);

            new Chart(ctxRendimiento, {
                type: 'bar',
                data: {
                    labels: labelsRendimiento,
                    datasets: [{
                        // Tickets Creados (BARRA AZUL)
                        label: 'Tickets Creados',
                        data: dataCreados,
                        backgroundColor: colores.primary,
                        borderColor: colores.primary,
                        borderWidth: 1,
                    }, {
                        // Tickets Cerrados (BARRA VERDE)
                        label: 'Tickets Cerrados',
                        data: dataCerrados, 
                        backgroundColor: colores.success,
                        borderColor: colores.success,
                        
                        // CLAVE: Establecer el tipo a 'bar'
                        type: 'bar', 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    scales: {
                         x: {
                            // Importante: stacked: false asegura que las barras vayan lado a lado
                            stacked: false, 
                        },
                        y: { 
                            beginAtZero: true 
                        }
                    }
                }
            });
        }


        // -------------------------------------------------------------------
        // GRÁFICO 2: TICKETS POR DEPARTAMENTO (DONA)
        // -------------------------------------------------------------------

        const ctxDepartamentos = document.getElementById('departamentosChart');
        if (ctxDepartamentos) {
            
            // Mapear los datos
            const labelsDepartamentos = datosDepartamentos.map(item => item.nombre_departamento);
            const dataTickets = datosDepartamentos.map(item => item.total);

            new Chart(ctxDepartamentos, {
                type: 'doughnut',
                data: {
                    labels: labelsDepartamentos,
                    datasets: [{
                        data: dataTickets,
                        backgroundColor: coloresDepartamentos.slice(0, labelsDepartamentos.length), 
                        hoverBackgroundColor: coloresDepartamentos.slice(0, labelsDepartamentos.length),
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                padding: 20
                            }
                        }
                    },
                },
            });
        }
    });
</script>

</body>
</html>