<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
</head>
<body>

<x-navbar />

<div class="ticket-header">
    <h2>Gestión de Tickets</h2>
</div>

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="ticket-body">

        <form method="GET" action="{{ route('gestion.tickets') }}" class="row g-3 mb-4">

            <div class="col-md-3">
                <label>Fecha inicio:</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            </div>

            <div class="col-md-3">
                <label>Fecha fin:</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}">
            </div>

            <div class="col-md-3">
                <label>Estatus:</label>
                <select name="estatus">
                    <option value="">Todos</option>
                    @foreach($estatus as $e)
                        <option value="{{ $e->id_estatus }}" {{ request('estatus') == $e->id_estatus ? 'selected' : '' }}>
                            {{ $e->nombre_estatus }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Mes:</label>
                <select name="mes">
                    <option value="">Todos</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->locale('es')->monthName }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label>Semana:</label>
                <select name="semana">
                    <option value="">Todas</option>
                    @for($i = 1; $i <= 52; $i++)
                        <option value="{{ $i }}" {{ request('semana') == $i ? 'selected' : '' }}>
                            Semana {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-3">
                <label>Departamento:</label>
                <select name="departamento">
                    <option value="">Todos</option>
                    @foreach($departamentos as $dep)
                        <option value="{{ $dep->id_departamento }}" {{ request('departamento') == $dep->id_departamento ? 'selected' : '' }}>
                            {{ $dep->nombre_departamento }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Auxiliar:</label>
                <select name="auxiliar">
                    <option value="">Todos</option>
                    @foreach($auxiliares as $aux)
                        <option value="{{ $aux->id_usuario }}" {{ request('auxiliar') == $aux->id_usuario ? 'selected' : '' }}>
                            {{ $aux->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 d-flex justify-content-end gap-3">
                <a href="{{ route('gestion.tickets') }}" class="btn-cancelar">Limpiar filtros</a>
                <button class="btn-enviar">Aplicar filtros</button>
            </div>

        </form>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Usuario</th>
                        <th>Departamento</th>
                        <th>Estatus</th>
                        <th>Auxiliar</th>
                        <th>Fecha creación</th>
                        <th>Asignar</th>
                        <th>Detalles</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id_ticket }}</td>
                            <td>{{ $ticket->titulo }}</td>
                            <td>{{ $ticket->usuario->nombre ?? 'Desconocido' }}</td>
                            <td>{{ $ticket->departamento->nombre_departamento ?? 'Sin departamento' }}</td>
                            <td>{{ $ticket->estatus->nombre_estatus ?? 'Sin estatus' }}</td>
                            <td>{{ $ticket->auxiliar->nombre ?? 'No asignado' }}</td>

                            <td>{{ \Carbon\Carbon::parse($ticket->fecha_creacion)->locale('es')->translatedFormat('d F Y') }}</td>

                            <td>
                                @if($ticket->id_auxiliar == null)
                                    <form action="{{ route('gestion.asignar', $ticket->id_ticket) }}" method="POST" class="d-flex gap-2 justify-content-center">
                                        @csrf
                                        <select name="id_auxiliar" required>
                                            <option value="">Seleccione</option>
                                            @foreach($auxiliares as $aux)
                                                <option value="{{ $aux->id_usuario }}">{{ $aux->nombre }}</option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="btn-enviar">Asignar</button>
                                    </form>
                                @else
                                    <form action="{{ route('gestion.cancelar', $ticket->id_ticket) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-cancelar">Cancelar</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm btn-detalle" 
                                        data-id="{{ $ticket->id_ticket }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetalleTicket">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay tickets registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav class="mt-3">
            {{ $tickets->links('pagination::bootstrap-5') }}
        </nav>

        <div class="form-buttons mt-4">
            <a href="{{ url()->previous() }}" class="btn-cancelar">Regresar</a>
        </div>

    </div>
</div>


<div class="modal fade" id="modalDetalleTicket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitulo">Cargando...</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Spinner de carga --}}
                <div class="text-center mb-3" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>

                {{-- Contenido: Solo Descripción y Evidencia --}}
                <div id="ticketContent" style="display: none;">
                    
                    <div class="mb-3">
                        <label class="fw-bold text-primary">Descripción del problema:</label>
                        <p id="modalDescripcion" class="p-3 rounded bg-light border mt-1" style="white-space: pre-wrap;"></p>
                    </div>

                    {{-- Botón de evidencia (solo si existe) --}}
                    <div id="areaEvidencia" class="d-none text-end">
                        <a href="#" id="linkEvidencia" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-paperclip"></i> Ver archivo adjunto
                        </a>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalDetalleTicket');
        
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; 
            const ticketId = button.getAttribute('data-id'); 

            // Referencias
            const spinner = document.getElementById('loadingSpinner');
            const content = document.getElementById('ticketContent');
            const titulo = document.getElementById('modalTitulo');
            const descripcion = document.getElementById('modalDescripcion');
            const areaEvidencia = document.getElementById('areaEvidencia');
            const linkEvidencia = document.getElementById('linkEvidencia');
            
            // Resetear estado
            spinner.style.display = 'block';
            content.style.display = 'none';
            titulo.textContent = 'Cargando...';
            descripcion.textContent = '';

            // Petición AJAX
            // NOTA: Asegúrate que esta ruta coincide con la de web.php
            fetch(`/jefe/gestion/ticket/detalle/${ticketId}`)
                .then(response => {
                    if (!response.ok) { throw new Error('Error en la red'); }
                    return response.json();
                })
                .then(data => {
                    titulo.textContent = data.titulo;
                    descripcion.textContent = data.descripcion;

                    if (data.evidencia) {
                        linkEvidencia.href = data.evidencia;
                        areaEvidencia.classList.remove('d-none');
                    } else {
                        areaEvidencia.classList.add('d-none');
                    }

                    spinner.style.display = 'none';
                    content.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    titulo.textContent = 'Error';
                    descripcion.textContent = 'No se pudo cargar la información del ticket. Intenta de nuevo.';
                    spinner.style.display = 'none';
                    content.style.display = 'block';
                });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
