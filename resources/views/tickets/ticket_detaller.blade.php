<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Ticket #{{ $ticket->id_ticket }} | Sistema de Tickets - Dulces Ricos</title>

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

        .btn-volver {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .btn-volver:hover {
            background-color: #5a6268;
            color: white;
        }

        .btn-actualizar {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
        }

        .btn-actualizar:hover {
            background-color: #3a5fc8;
        }

        .estado-pendiente {
            background-color: #fcefc7;
            color: #946c00;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-proceso {
            background-color: #cce7ff;
            color: #0066cc;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-resuelto {
            background-color: #d1f7c4;
            color: #0d6b0d;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-cancelado {
            background-color: #f8d7da;
            color: #721c24;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
        }

        .info-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #4e73df;
        }

        .info-label {
            font-weight: 600;
            color: #4e73df;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 16px;
            color: #2c3e50;
        }

        .descripcion-card {
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .descripcion-titulo {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .descripcion-texto {
            font-size: 15px;
            line-height: 1.8;
            color: #495057;
            white-space: pre-wrap;
        }

        .control-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            border: 2px solid #dee2e6;
        }

        .control-titulo {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-select, .form-control {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 10px 15px;
        }

        .form-select:focus, .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .badge-ticket {
            background-color: #e9ecef;
            color: #495057;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 18px;
        }

        .timeline-item {
            border-left: 3px solid #4e73df;
            padding-left: 20px;
            padding-bottom: 20px;
            position: relative;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            width: 12px;
            height: 12px;
            background-color: #4e73df;
            border-radius: 50%;
            position: absolute;
            left: -7.5px;
            top: 5px;
        }

        .timeline-fecha {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        .timeline-contenido {
            font-size: 14px;
            color: #495057;
            margin-top: 5px;
        }

        .alerta-info {
            background-color: #e7f3ff;
            border-left: 4px solid #0066cc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .icon-circle {
            width: 35px;
            height: 35px;
            background-color: #4e73df;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 10px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="panel-card">
    <div class="panel-header">
        <h2>Detalles del Ticket</h2>
        <p>Gestiona y actualiza el estado del ticket</p>
        @if($auxiliar && $auxiliar->foto_perfil)
            <img src="{{ asset('storage/' . $auxiliar->foto_perfil) }}" alt="Foto de perfil" class="foto-perfil">
        @else
            <div class="foto-perfil d-flex align-items-center justify-content-center" style="background-color: #4e73df; color: white; font-size: 32px; font-weight: 600;">
                {{ strtoupper(substr($auxiliar->nombre ?? 'A', 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="panel-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <span class="badge-ticket">#{{ $ticket->id_ticket }}</span>
            </h4>
            <a href="{{ route('auxiliar.tickets') }}" class="btn btn-volver">
                <i class="bi bi-arrow-left"></i> Volver al Listado
            </a>
        </div>

        <!-- Información General del Ticket -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-label"><i class="bi bi-card-heading"></i> Título del Ticket</div>
                    <div class="info-value">{{ $ticket->titulo }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-card">
                    <div class="info-label"><i class="bi bi-calendar-event"></i> Fecha de Creación</div>
                    <div class="info-value">{{ $ticket->fecha_creacion ? $ticket->fecha_creacion->format('d/m/Y H:i') : 'No disponible' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-card">
                    <div class="info-label"><i class="bi bi-flag-fill"></i> Estado Actual</div>
                    <div class="info-value">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-label"><i class="bi bi-person-fill"></i> Creado por</div>
                    <div class="info-value">{{ $ticket->usuario->nombre ?? 'Usuario desconocido' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-label"><i class="bi bi-person-badge-fill"></i> Asignado a</div>
                    <div class="info-value">
                        @if($ticket->asignado)
                            {{ $ticket->asignado->nombre }}
                        @else
                            <span class="text-muted">No asignado</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción del Problema -->
        <div class="descripcion-card">
            <div class="descripcion-titulo">
                <div class="icon-circle">
                    <i class="bi bi-file-text-fill"></i>
                </div>
                Descripción del Problema
            </div>
            <div class="descripcion-texto">
                {{ $ticket->descripcion ?? $ticket->description ?? 'Sin descripción' }}
            </div>
        </div>

        <!-- Alerta informativa -->
        @if($ticket->estatus && $ticket->estatus->nombre_estatus != 'cancelado')
        <div class="alerta-info">
            <i class="bi bi-info-circle-fill"></i>
            <strong>Nota:</strong> Actualiza el estado del ticket según el progreso de la resolución del problema. Recuerda establecer una fecha de finalización cuando marques el ticket como "Resuelto".
        </div>
        @endif

        <!-- Controles para Actualizar Estado -->
        @if($ticket->estatus && $ticket->estatus->nombre_estatus != 'cancelado')
        <div class="control-card">
            <div class="control-titulo">
                <div class="icon-circle">
                    <i class="bi bi-gear-fill"></i>
                </div>
                Controles de Actualización
            </div>

            <form action="{{ route('auxiliar.tickets.actualizar', $ticket->id_ticket) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            <i class="bi bi-arrow-repeat"></i> Cambiar Estado
                        </label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="">Selecciona un estado...</option>
                            <option value="proceso" {{ ($ticket->estatus && $ticket->estatus->nombre_estatus == 'proceso') ? 'selected' : '' }}>
                                En Proceso
                            </option>
                            <option value="resuelto" {{ ($ticket->estatus && $ticket->estatus->nombre_estatus == 'resuelto') ? 'selected' : '' }}>
                                Resuelto
                            </option>
                        </select>
                        <div class="form-text">Actualiza el estado según el progreso del ticket</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fecha_finalizacion" class="form-label">
                            <i class="bi bi-calendar-check"></i> Fecha de Finalización
                        </label>
                        <input type="datetime-local" 
                               class="form-control" 
                               id="fecha_finalizacion" 
                               name="fecha_finalizacion"
                               value="{{ $ticket->fecha_finalizacion ? $ticket->fecha_finalizacion->format('Y-m-d\TH:i') : '' }}"
                               min="{{ now()->format('Y-m-d\TH:i') }}">
                        <div class="form-text">Requerido al marcar como "Resuelto"</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">
                        <i class="bi bi-chat-left-text"></i> Comentario o Notas (Opcional)
                    </label>
                    <textarea class="form-control" 
                              id="comentario" 
                              name="comentario" 
                              rows="4" 
                              placeholder="Agrega comentarios sobre la actualización del ticket...">{{ old('comentario') }}</textarea>
                    <div class="form-text">Puedes agregar detalles sobre los cambios realizados</div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-actualizar">
                        <i class="bi bi-check-circle"></i> Actualizar Ticket
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <strong>Ticket Cancelado:</strong> Este ticket ha sido cancelado y no puede ser actualizado.
        </div>
        @endif

        <!-- Historial de Cambios -->
        @if(isset($historial) && count($historial) > 0)
        <div class="mt-4">
            <h5 class="mb-3">
                <i class="bi bi-clock-history"></i> Historial de Cambios
            </h5>
            <div class="ps-3">
                @foreach($historial as $cambio)
                <div class="timeline-item">
                    <div class="timeline-fecha">{{ $cambio->fecha->format('d/m/Y H:i') }}</div>
                    <div class="timeline-contenido">
                        <strong>{{ $cambio->accion }}</strong> - {{ $cambio->detalle }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<footer>
    <p>&copy; {{ date('Y') }} Sistema de Tickets - Dulces Ricos. Todos los derechos reservados.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Validación: Si se selecciona "Resuelto", la fecha de finalización es obligatoria
    document.querySelector('form').addEventListener('submit', function(e) {
        const estado = document.getElementById('estado').value;
        const fechaFinalizacion = document.getElementById('fecha_finalizacion').value;
        
        if (estado === 'resuelto' && !fechaFinalizacion) {
            e.preventDefault();
            alert('Por favor, establece una fecha de finalización para marcar el ticket como resuelto.');
            document.getElementById('fecha_finalizacion').focus();
        }
    });

    // Auto-rellenar fecha actual al seleccionar "Resuelto"
    document.getElementById('estado').addEventListener('change', function() {
        const fechaInput = document.getElementById('fecha_finalizacion');
        if (this.value === 'resuelto' && !fechaInput.value) {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            fechaInput.value = now.toISOString().slice(0, 16);
        }
    });
</script>

</body>
</html>