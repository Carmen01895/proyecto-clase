<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Sistema de Tickets - Dulces Ricos</title>

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

        input[readonly] {
            background-color: #f7f7f7;
            border: 1px solid #ddd;
        }

        .btn-editar {
            background-color: #1cc88a;
            color: white;
            border: none;
        }

        .btn-editar:hover {
            background-color: #17a673;
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
        <h2>Perfil del Usuario</h2>
        <p>Información personal registrada en el sistema</p>
        <img src="{{ asset('images/perfil.jpg') }}" alt="Foto de perfil" class="foto-perfil">
    </div>

    <div class="perfil-body">
        <form>
            <div class="row g-4">
                
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control" value="Fanny" readonly>
                </div>
                
                <div class="col-md-6">
                    <label>Apellido</label>
                    <input type="text" class="form-control" value="Alegría" readonly>
                </div>

                <div class="col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" class="form-control" value="fanny@example.com" readonly>
                </div>

                <div class="col-md-6">
                    <label>Departamento</label>
                    <input type="text" class="form-control" value="Soporte Técnico" readonly>
                </div>

                <div class="col-md-6">
                    <label>Puesto</label>
                    <input type="text" class="form-control" value="Usuario" readonly>
                </div>
                
                </div>

            <div class="text-center mt-5">
               <a href="editar-perfil.html" class="btn btn-editar">Editar Datos</a>
            </div>
        </form>
    </div>
</div>

<footer>
    Sistema de Gestión de Tickets © Dulces Ricos 
</footer>

</body>
</html>