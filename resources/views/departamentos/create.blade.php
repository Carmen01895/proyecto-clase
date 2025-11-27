<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Departamento | Sistema de Tickets</title>

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
            max-width: 900px;
            margin: 50px auto;
        }
        .perfil-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 40px 20px 60px;
            text-align: center;
            position: relative;
        }
        .perfil-body {
            padding: 60px 50px 40px;
        }
        label { font-weight: 600; color: #444; }
        .btn-editar { background-color: #1cc88a; color: white; border: none; padding: 10px 25px; }
        .btn-editar:hover { background-color: #17a673; }
    </style>
</head>
<body>

<x-navbar />

<div class="perfil-card">
    <div class="perfil-header">
        <h2>Crear Departamento</h2>
        <p>Agregar un nuevo departamento al sistema</p>
    </div>

    <div class="perfil-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('departamentos.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label>Nombre del Departamento</label>
                    <input type="text" name="nombre_departamento" class="form-control" value="{{ old('nombre_departamento') }}" required>
                </div>
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-editar">Guardar Departamento</button>
                <a href="{{ route('departamentos.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<footer style="text-align:center; color:#777; margin-top:20px; font-size:13px;">Sistema de Tickets &copy; 2025</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
