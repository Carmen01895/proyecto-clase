<!DOCTYPE html>
@php
    use Illuminate\Support\Facades\Storage;
@endphp
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets | Sistema de Tickets - Dulces Ricos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f3f6fb;
            font-family: 'Poppins', sans-serif;
        }

        .panel-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1200px;
            margin: 30px auto;
        }

        .panel-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .foto-perfil {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
            position: absolute;
            right: 30px;
            top: 30px;
            background-color: white;
        }

        .panel-body {
            padding: 30px;
        }

        .btn-nuevo {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-nuevo:hover {
            background-color: #3a5fc8;
        }

        .btn-cancelar {
            background-color: #e74a3b;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-cancelar:hover {
            background-color: #d52a1a;
        }

        .btn-cancelar:disabled {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn-buscar {
            background-color: #1cc88a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-buscar:hover {
            background-color: #17a673;
        }

        .btn-limpiar {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-limpiar:hover {
            background-color: #5a6268;
        }

        .estado-pendiente {
            background-color: #fcefc7;
            color: #946c00;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .estado-proceso {
            background-color: #cce7ff;
            color: #0066cc;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .estado-resuelto {
            background-color: #d1f7c4;
            color: #0d6b0d;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .estado-cancelado {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .tabla-tickets {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .tabla-tickets thead {
            background-color: #4e73df;
            color: white;
        }

        .tabla-tickets th {
            font-weight: 600;
            padding: 15px;
        }

        .tabla-tickets td {
            padding: 15px;
            vertical-align: middle;
        }

        .tabla-tickets tbody tr:hover {
            background-color: #f8f9fa;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }

        .badge-ticket {
            background-color: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
        }

        .filtros {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .filtro-separado {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .filtro-separado:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</head>
<body>
<x-navbar />

<div class="panel-card">
    <div class="panel-header">
        <h2>Mis Tickets</h2>
        <p>Visualiza el historial y estado de tus tickets</p>
        @if($usuario && $usuario->foto_perfil)
            <img src="{{ Storage::url($usuario->foto_perfil) }}" alt="Foto de perfil" class="foto-perfil">
        @else
            <div class="foto-perfil d-flex align-items-center justify-content-center" style="background-color: #4e73df; color: white; font-size: 32px; font-weight: 600;">
                {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="panel-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Listado de Tickets</h4>
            <a href="{{ route('tickets.create') }}" class="btn btn-nuevo">
                <i class="bi bi-plus-circle"></i> Nuevo Ticket
            </a>
        </div>

        <!-- Filtros Separados -->
        <div class="filtros">
            <!-- Filtro por Estado (se aplica automáticamente) -->
            <div class="filtro-separado">
                <form method="GET" action="{{ route('tickets.historial') }}" class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <label class="form-label"><strong>Filtrar por estado:</strong></label>
                        <select class="form-select" name="filtro_estado" onchange="this.form.submit()">
                            <option value="todos" {{ request('filtro_estado', 'todos') == 'todos' ? 'selected' : '' }}>Todos los estados</option>
                            <option value="pendiente" {{ request('filtro_estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="proceso" {{ request('filtro_estado') == 'proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="resuelto" {{ request('filtro_estado') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                            <option value="cancelado" {{ request('filtro_estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-text">Se aplica automáticamente al seleccionar</div>
                    </div>
                </form>
            </div>

            <!-- Ordenar por (se aplica automáticamente) -->
            <div class="filtro-separado">
                <form method="GET" action="{{ route('tickets.historial') }}" class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <label class="form-label"><strong>Ordenar por:</strong></label>
                        <select class="form-select" name="ordenar_por" onchange="this.form.submit()">
                            <option value="fecha-desc" {{ request('ordenar_por', 'fecha-desc') == 'fecha-desc' ? 'selected' : '' }}>Fecha (más reciente primero)</option>
                            <option value="fecha-asc" {{ request('ordenar_por') == 'fecha-asc' ? 'selected' : '' }}>Fecha (más antiguo primero)</option>
                            <option value="estado" {{ request('ordenar_por') == 'estado' ? 'selected' : '' }}>Estado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-text">Se aplica automáticamente al seleccionar</div>
                    </div>
                </form>
            </div>

            <!-- Buscar por ID (con botón) -->
            <div class="filtro-separado">
                <form method="GET" action="{{ route('tickets.historial') }}" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Buscar por ID de ticket:</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="buscar_id" placeholder="Ej: 1, 2, 3..." value="{{ request('buscar_id') }}">
                            <button type="submit" class="btn btn-buscar">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-text">Ingresa el número específico del ticket</div>
                    </div>
                </form>
            </div>

            <!-- Botón Limpiar Filtros -->
            <div class="text-center mt-3">
                <a href="{{ route('tickets.historial') }}" class="btn btn-limpiar">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar Todos los Filtros
                </a>
            </div>
        </div>

        <!-- Información de filtros aplicados -->
        @if(request()->has('filtro_estado') && request('filtro_estado') != 'todos' || request()->has('buscar_id'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Filtros aplicados:</strong>
            @if(request()->has('filtro_estado') && request('filtro_estado') != 'todos')
                <span class="badge bg-primary">Estado: {{ ucfirst(request('filtro_estado')) }}</span>
            @endif
            @if(request()->has('buscar_id') && request('buscar_id'))
                <span class="badge bg-success">ID: {{ request('buscar_id') }}</span>
            @endif
            @if(request()->has('ordenar_por') && request('ordenar_por') != 'fecha-desc')
                <span class="badge bg-secondary">Orden: 
                    @if(request('ordenar_por') == 'fecha-asc') Más antiguo primero
                    @elseif(request('ordenar_por') == 'estado') Por estado
                    @endif
                </span>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Tabla de tickets -->
        <div class="table-responsive">
            <table class="table tabla-tickets">
                <thead>
                    <tr>
                        <th>ID Ticket</th>
                        <th>Fecha</th>
                        <th>Asunto</th>
                        <th>Asignado a</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td>
                            <span class="badge-ticket">#{{ $ticket->id_ticket }}</span>
                        </td>
                        <td>{{ $ticket->fecha_creacion->format('d/m/Y H:i') }}</td>
                        <td>
                            <strong>{{ $ticket->titulo }}</strong><br>
                            <small class="text-muted">{{ Str::limit($ticket->description, 50) }}</small>
                        </td>
                        <td>
                            @if($ticket->asignado)
                                {{ $ticket->asignado->nombre }}
                            @else
                                <span class="text-muted">No asignado</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $estadoClass = 'estado-pendiente';
                                $estadoText = 'Pendiente';
                                
                                if($ticket->estatus) {
                                    switch($ticket->estatus->nombre_estatus) {
                                        case 'pendiente': 
                                            $estadoClass = 'estado-pendiente';
                                            $estadoText = 'Pendiente';
                                            break;
                                        case 'proceso': 
                                            $estadoClass = 'estado-proceso';
                                            $estadoText = 'En proceso';
                                            break;
                                        case 'resuelto': 
                                            $estadoClass = 'estado-resuelto';
                                            $estadoText = 'Resuelto';
                                            break;
                                        case 'cancelado': 
                                            $estadoClass = 'estado-cancelado';
                                            $estadoText = 'Cancelado';
                                            break;
                                    }
                                }
                            @endphp
                            <span class="{{ $estadoClass }}">{{ $estadoText }}</span>
                        </td>
                        <td>
                            @if($ticket->estatus && $ticket->estatus->nombre_estatus == 'pendiente')
                                <form action="{{ route('tickets.cancelar', $ticket->id_ticket) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-cancelar btn-sm" 
                                            onclick="return confirm('¿Estás seguro de que deseas cancelar este ticket?')">
                                        Cancelar
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-cancelar btn-sm" disabled>Cancelar</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                @if(request()->has('filtro_estado') && request('filtro_estado') != 'todos' || request()->has('buscar_id'))
                                    No se encontraron tickets con los filtros aplicados
                                @else
                                    No se encontraron tickets
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($tickets->hasPages())
        <nav aria-label="Navegación de páginas">
            <ul class="pagination justify-content-center mt-4">
                {{ $tickets->appends(request()->query())->links() }}
            </ul>
        </nav>
        @endif
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>