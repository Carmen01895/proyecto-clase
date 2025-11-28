<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levantar Ticket de Soporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
</head>
<body>
    <x-navbar />

    <div class="ticket-form-container">
        <div class="ticket-header">
            <h2>Levantar Ticket de Soporte</h2>
        </div>

        <div class="ticket-body">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre del empleado</label>
                    <input type="text" id="nombre" name="nombre" value="{{ $usuario->nombre }} {{ $usuario->apellido }}" readonly>
                </div>

                <div class="form-group">
                    <label for="puesto">Departamento</label>
                    <input type="text" id="departamento" class="form-control" 
                           value="{{ $usuario->departamento->nombre_departamento ?? 'Sin Departamento asignado' }}" 
                           readonly>
                </div>

                <div class="form-group">
                    <label for="titulo">Título del problema</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ejemplo: No puedo imprimir" minlength="8" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción detallada</label>
                    <textarea id="descripcion" name="descripcion" rows="5" placeholder="Describe tu problema con detalle..." minlength="20" required></textarea>
                </div>

                <div class="form-group">
                    <label for="archivo">Adjuntar evidencia (opcional)</label>
                    <input type="file" id="archivo" name="archivo" accept="image/*,.pdf">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-enviar">Enviar Ticket</button>
                    <a href="{{ url()->previous() }}" class="btn-cancelar">Cancelar</a>

                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
