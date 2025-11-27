<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Asignados | Sistema de Tickets - Dulces Ricos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body { 
            background-color: #f3f6fb; 
            font-family: 'Poppins', sans-serif; 
        }
        .header-bar {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 0 0 15px 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .ticket-table {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden; 
        }
        .badge-estado {
            font-size: 0.9em;
            padding: 0.5em 0.8em;
            border-radius: 20px;
        }
        .badge-pendiente { background-color: #f6c23e; color: white; }
        .badge-abierto { background-color: #4e73df; color: white; }
        .badge-resuelto { background-color: #1cc88a; color: white; }
        .badge-cancelado { background-color: #858796; color: white; }
    </style>
</head>
<body>

    <x-navbar />

    {{-- CAMBIO 1: Agregué 'mt-5' aquí. Esto separa el título del navbar --}}
    <div class="container mt-5">

        <div class="header-bar">
            <h2>Tickets Asignados</h2>
            <p>Esta es tu bandeja de entrada de tickets por resolver.</p>
        </div>

        <div class="ticket-table">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Ticket</th>
                        <th>Asunto</th>
                        <th>Creado por</th>
                        <th>Estado</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>#{{ $ticket->id_ticket }}</td>
                            <td>{{ $ticket->titulo }}</td>

                            {{-- CAMBIO 2: Corregido a 'usuario' para que no de error --}}
                            <td>{{ $ticket->usuario->nombre ?? 'N/A' }}</td>

                            <td>
                                <span class="badge badge-estado badge-abierto">
                                    {{ $ticket->estatus->nombre_estatus ?? 'Sin estado' }}
                                </span>
                            </td>

                            <td>{{ $ticket->fecha_creacion->format('d/m/Y H:i') }}</td>

                            <td>
                                {{-- CAMBIO 3: ¡AQUÍ ESTÁ TU BOTÓN! Ya lo tenías, solo verifiqué la ruta --}}
                                <a href="{{ route('tickets.detalle', ['id' => $ticket->id_ticket]) }}" class="btn btn-primary btn-sm">
                                    Ver Detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <p class="fs-4">¡Felicidades!</p>
                                <p class="text-muted">No tienes tickets asignados por el momento.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>