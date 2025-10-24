<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil | Sistema de Tickets - Dulces Ricos</title>

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
            padding: 40px 20px 80px;
            text-align: center;
            position: relative;
        }

        .foto-perfil {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: -70px;
            background-color: white;
        }

        .perfil-body {
            padding: 100px 50px 40px;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        /* Ya no necesitamos el estilo para [readonly] */
        
        .btn-editar {
            background-color: #1cc88a;
            color: white;
            border: none;
            padding: 10px 25px; /* Ajuste leve para mejor apariencia */
        }

        .btn-editar:hover {
            background-color: #17a673;
        }
        
        /* Estilo para el botón cancelar */
        .btn-cancelar {
            background-color: #858796;
            color: white;
            border: none;
            padding: 10px 25px;
        }
        .btn-cancelar:hover {
            background-color: #707280;
            color: white;
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

<div class="perfil-card">
    <div class="perfil-header">
        <h2>Editar Perfil</h2>
        <p>Actualiza tu información personal</p>
        <img src="{{ asset('images/perfil.jpg') }}" alt="Foto de perfil" class="foto-perfil">
    </div>

    <div class="perfil-body">
        
        <form method="POST" action="{{ url('/guardar-perfil') }}">
            @csrf 
            @method('PUT') <div class="row g-4">
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control" value="Fanny" name="nombre">
                </div>
                <div class="col-md-6">
                    <label>Apellido</label>
                    <input type="text" class="form-control" value="Alegría" name="apellido">
                </div>
                <div class="col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" class="form-control" value="fanny@example.com" name="correo">
                </div>
                <div class="col-md-6">
                    <label>Departamento</label>
                    <input type="text" class="form-control" value="Soporte Técnico" name="departamento" readonly>
                </div>
                <div class="col-md-6">
                    <label>Puesto</label>
                    <input type="text" class="form-control" value="Usuario" name="puesto" readonly>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-editar">Guardar Cambios</button>
                
                <a href="{{ url('/mi-perfil') }}" class="btn btn-cancelar ms-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>