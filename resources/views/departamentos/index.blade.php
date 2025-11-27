<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos | Sistema de Tickets</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3f6fb;
            font-family: 'Poppins', sans-serif;
        }
        .perfil-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1100px;
            margin: 40px auto;
        }
        .perfil-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 28px 24px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .perfil-header h3 { margin:0; }
        .perfil-body { padding: 28px; }
        .tabla-departamentos th { background-color: #4e73df; color: white; }
        .btn-editar { background-color: #1cc88a; color: white; border: none; padding: 8px 18px; }
    </style>
</head>
<body>

<x-navbar />

<div class="perfil-card">
    <div class="perfil-header">
        <h3>Departamentos</h3>
        <a href="{{ route('departamentos.create') }}" class="btn btn-editar">Crear Departamento</a>
    </div>

    <div class="perfil-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered tabla-departamentos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departamentos as $d)
                        <tr>
                            <td>{{ $d->id_departamento }}</td>
                            <td>{{ $d->nombre_departamento }}</td>
                            <td>
                                <a href="{{ route('departamentos.edit', $d->id_departamento) }}" class="btn btn-sm btn-info text-white">Editar</a>
                                <form action="{{ route('departamentos.destroy', $d->id_departamento) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar departamento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay departamentos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer style="text-align:center; color:#777; margin-top:20px; font-size:13px;">Sistema de Tickets &copy; 2025</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
