<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulces Ricos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #4e73df; 
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 450px;
            width: 90%;
            text-align: center;
        }

        .login-card h2 {
            font-weight: 600;
            color: #4e73df;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            color: #444;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }

        .btn-login {
            background-color: #1cc88a; 
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 15px;
        }

        .btn-login:hover {
            background-color: #17a673;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Iniciar Sesión</h2>
    <p class="text-muted mb-4">Ingresa tus credenciales para acceder al sistema.</p>

    <form>
        <div class="mb-3 text-start">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" id="usuario" placeholder="ejemplo01" required>
        </div>

        <div class="mb-4 text-start">
            <label for="contrasena">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" placeholder="********" required>
        </div>

        <button type="submit" class="btn btn-login">Acceder</button>

        <div class="mt-3">
            <a href="#" class="text-primary" style="font-size: 0.9rem;">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
</div>

</body>
</html>