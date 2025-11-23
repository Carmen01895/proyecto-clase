<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
