<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Tickets - Dulces Ricos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f3f6fb;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex; 
            flex-direction: column;
        }

        .glass-container {
            background-color: rgba(255, 255, 255, 0.6); 
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 90%;
            margin: auto;
        }
        
        .welcome-column {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 3rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-column .logo-img {
            width: 80px; 
            height: 80px;
            margin: 0 auto 1.5rem auto; 
            object-fit: contain; 
        }

        .login-form-content {
            padding: 3rem;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
        }

        .btn-login {
            background-color: #1cc88a;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }

        .btn-login:hover {
            background-color: #17a673;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px 0;
            color: #777;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container d-flex flex-grow-1 align-items-center justify-content-center">
    <div class="glass-container row g-0">
        
        <div class="col-md-6 order-md-1 login-form-content">
            <h2 class="text-3xl font-weight-bold mb-3" style="color:#4e73df;">Iniciar Sesión</h2>
            <p class="text-secondary mb-4">Ingresa tus credenciales para acceder al sistema</p>
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-4">
                    <label for="email">Correo de Usuario</label>
                    <input 
                        type="email" 
                        name="correo" 
                        class="form-control @error('correo') is-invalid @enderror" 
                        id="correo" 
                        required 
                        autofocus>
                    @error('correo')
                        <div class="invalid-feedback" d-block>
                            {{ $message }}
                            </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        required>
                    @error('password')
                        <div class="invalid-feedback" d-block>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @if($errors->has('correo') && $errors->first('correo') == 'Estas credenciales no coinciden con nuestros registros.')
                    <div class="alert alert-danger"> {{$errors->first('correo')}} </div>
                @endif

                <button type="submit" class="btn btn-login">Acceder</button>
            </form>
        </div>

        <div class="col-md-6 order-md-2 welcome-column">
            <img 
                src="{{ asset('images/logo.png') }}" 
                alt="Logo Dulces Ricos" 
                class="logo-img"
            >
            <h3 class="font-weight-bold mb-3">Dulces Ricos</h3>
            <p class="lead">
                Estamos felices de verte. Accede para gestionar tus tickets.
            </p>
        </div>

    </div>
</div>

<footer>
    Sistema de Gestión de Tickets © Dulces Ricos
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>