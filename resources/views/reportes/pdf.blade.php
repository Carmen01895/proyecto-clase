<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 11px; 
            color: #333;
            line-height: 1.6;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%);
            color: white;
            padding: 30px 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header p {
            font-size: 12px;
            opacity: 0.9;
        }

        .fecha {
            font-size: 10px;
            margin-top: 5px;
            opacity: 0.85;
        }

        /* ESTADÍSTICAS */
        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 15px;
            border-right: 1px solid #e0e0e0;
        }

        .stat-box:last-child {
            border-right: none;
        }

        .stat-box.blue { background: rgba(78, 115, 223, 0.05); border-left: 4px solid #4e73df; }
        .stat-box.green { background: rgba(28, 200, 138, 0.05); border-left: 4px solid #1cc88a; }

        .stat-label {
            font-size: 10px;
            color: #666;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .stat-box.blue .stat-value { color: #4e73df; }
        .stat-box.green .stat-value { color: #1cc88a; }

        /* SECCIONES */
        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%);
            color: white;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 3px;
        }

        /* TABLAS */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        thead {
            background: #4e73df;
            color: white;
        }

        thead th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            border-bottom: 2px solid #1cc88a;
        }

        tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #f0f7ff;
        }

        /* BADGES */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }

        .badge-pendiente { background: #ff6b6b; }
        .badge-proceso { background: #ffa502; }
        .badge-resuelto { background: #1cc88a; }
        .badge-cancelado { background: #999; }

        .badge-id { background: #4e73df; }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            font-size: 9px;
            color: #999;
        }

        .footer-brand {
            font-weight: bold;
            color: #4e73df;
        }

        /* RESUMEN */
        .resumen-container {
            display: table;
            width: 100%;
            margin-top: 25px;
        }

        .resumen-col {
            display: table-cell;
            width: 33%;
            vertical-align: top;
            padding-right: 15px;
        }

        .resumen-col:last-child {
            padding-right: 0;
        }

        .resumen-title {
            font-size: 12px;
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #1cc88a;
        }

        .resumen-item {
            padding: 8px 0;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #f0f0f0;
        }

        .resumen-label { font-weight: bold; }
        .resumen-valor { color: #1cc88a; font-weight: bold; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1>📊 REPORTE DE TICKETS</h1>
        <p>Sistema de Gestión de Tickets - Dulces Ricos</p>
        <div class="fecha">Generado el {{ now()->format('d/m/Y \a \l\a\s H:i:s') }}</div>
    </div>

    <!-- ESTADÍSTICAS -->
    @if(isset($estadisticas))
    <div class="stats-container">
        <div class="stat-box blue">
            <div class="stat-label">Total de Tickets</div>
            <div class="stat-value">{{ $estadisticas['total'] }}</div>
        </div>
        <div class="stat-box green">
            <div class="stat-label">Técnicos Activos</div>
            <div class="stat-value">{{ count($estadisticas['por_auxiliar']) }}</div>
        </div>
        <div class="stat-box blue">
            <div class="stat-label">Tiempo Promedio</div>
            <div class="stat-value">{{ $estadisticas['tiempo_promedio'] }}d</div>
        </div>
        <div class="stat-box green">
            <div class="stat-label">Departamentos</div>
            <div class="stat-value">{{ count($estadisticas['por_departamento']) }}</div>
        </div>
    </div>
    @endif

    <!-- TABLA PRINCIPAL -->
    <div class="section">
        <div class="section-title">📋 Detalle de Tickets</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">ID</th>
                    <th style="width: 25%;">Descripción</th>
                    <th style="width: 15%;">Técnico</th>
                    <th style="width: 15%;">Departamento</th>
                    <th style="width: 12%;">Estado</th>
                    <th style="width: 15%;">Fecha Creación</th>
                    <th style="width: 10%;">Fin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td><span class="badge badge-id">#{{ $t->id_ticket }}</span></td>
                    <td>{{ substr($t->descripcion, 0, 50) }}{{ strlen($t->descripcion) > 50 ? '...' : '' }}</td>
                    <td>{{ $t->auxiliar->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $t->departamento->nombre_departamento ?? 'N/A' }}</td>
                    <td>
                        @php
                            $statusClass = 'badge-' . strtolower($t->estatus->nombre ?? 'cancelado');
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ strtoupper($t->estatus->nombre ?? 'N/A') }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($t->fecha_creacion)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($t->fecha_finalizacion)
                            {{ \Carbon\Carbon::parse($t->fecha_finalizacion)->format('d/m/Y') }}
                        @else
                            <em style="color: #999;">Pendiente</em>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        No hay tickets que mostrar con los filtros aplicados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- RESUMEN POR ESTATUS -->
    @if(isset($estadisticas) && !empty($estadisticas['por_estatus']))
    <div class="section">
        <div class="section-title">📊 Resumen por Estado</div>
        <div class="resumen-container">
            @php
                $por_estatus = $estadisticas['por_estatus'];
                $estatus_list = array_chunk($por_estatus, ceil(count($por_estatus) / 3), true);
            @endphp
            
            @foreach($estatus_list as $chunk)
            <div class="resumen-col">
                @foreach($chunk as $estatus => $cantidad)
                <div class="resumen-item">
                    <span class="resumen-label">{{ ucfirst($estatus) }}:</span>
                    <span class="resumen-valor">{{ $cantidad }}</span>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- RESUMEN POR AUXILIAR -->
    @if(isset($estadisticas) && !empty($estadisticas['por_auxiliar']))
    <div class="section">
        <div class="section-title">👥 Distribución por Técnico</div>
        <div class="resumen-container">
            @php
                $por_auxiliar = $estadisticas['por_auxiliar'];
                $auxiliar_list = array_chunk($por_auxiliar, ceil(count($por_auxiliar) / 3), true);
            @endphp
            
            @foreach($auxiliar_list as $chunk)
            <div class="resumen-col">
                @foreach($chunk as $auxiliar => $cantidad)
                <div class="resumen-item">
                    <span class="resumen-label">{{ $auxiliar }}:</span>
                    <span class="resumen-valor">{{ $cantidad }}</span>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- RESUMEN POR DEPARTAMENTO -->
    @if(isset($estadisticas) && !empty($estadisticas['por_departamento']))
    <div class="section">
        <div class="section-title">🏢 Distribución por Departamento</div>
        <div class="resumen-container">
            @php
                $por_departamento = $estadisticas['por_departamento'];
                $depto_list = array_chunk($por_departamento, ceil(count($por_departamento) / 3), true);
            @endphp
            
            @foreach($depto_list as $chunk)
            <div class="resumen-col">
                @foreach($chunk as $departamento => $cantidad)
                <div class="resumen-item">
                    <span class="resumen-label">{{ $departamento }}:</span>
                    <span class="resumen-valor">{{ $cantidad }}</span>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-brand">Sistema de Gestión de Tickets - Dulces Ricos</div>
        <p>Este reporte ha sido generado automáticamente. Para consultas adicionales, contacte con el administrador.</p>
    </div>

</body>
</html>

