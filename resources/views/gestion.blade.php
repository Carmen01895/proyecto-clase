<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Sistema de Tickets - Dulces Ricos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3f6fb;
            font-family: 'Poppins', sans-serif;
        }

        .usuarios-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1200px;
            margin: 50px auto;
        }

        .usuarios-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .usuarios-body {
            padding: 50px;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        .btn-guardar {
            background-color: #1cc88a;
            color: white;
            border: none;
        }

        .btn-guardar:hover {
            background-color: #17a673;
        }

        .tabla-usuarios th {
            background-color: #4e73df;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="usuarios-card">
    <div class="usuarios-header">
        <h2>Gestión de Usuarios</h2>
        <p>Administrar las cuentas de los empleados</p>
    </div>

    <div class="usuarios-body">
        <h4 class="mb-4">Registrar nuevo usuario</h4>

        {{-- 1. BLOQUE PARA MOSTRAR MENSAJES DE ÉXITO (del controlador) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        {{-- 2. BLOQUE PARA MOSTRAR ERRORES DE VALIDACIÓN (automático de Laravel) --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                **Por favor, corrige los siguientes errores en el formulario:**
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO MODIFICADO --}}
        <form id="formUsuario" method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data">
            @csrf <div class="row g-4">
                <div class="col-md-6">
                    <label>Nombre(s)</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej. Ana" value="{{ old('nombre') }}">
                    <small class="error" id="errorNombre"></small>
                </div>

                <div class="col-md-6">
                    <label>Apellido(s)</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ej. Martínez" value="{{ old('apellido') }}">
                    <small class="error" id="errorApellido"></small>
                </div>

                <div class="col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" id="correo" name="email" class="form-control" placeholder="Ej. ana@example.com" value="{{ old('email') }}">
                    <small class="error" id="errorCorreo"></small>
                </div>

                <div class="col-md-6">
                    <label>Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres">
                    <small class="error" id="errorPassword"></small>
                </div>

                <div class="col-md-6">
                    <label>Rol</label>
                    <select id="rol" name="id_rol" class="form-select">
                        <option value="">Seleccionar...</option>
                        {{-- Usando los IDs de rol de tu conversación anterior: 1=Admin, 2=Jefe, 3=Empleado --}}
                        <option value="3" {{ old('id_rol') == '3' ? 'selected' : '' }}>Empleado</option>
                        <option value="2" {{ old('id_rol') == '2' ? 'selected' : '' }}>Jefe</option>
                        <option value="1" {{ old('id_rol') == '1' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <small class="error" id="errorRol"></small>
                </div>

                <div class="col-md-6">
                    <label>Puesto</label>
                    <input type="text" id="puesto" name="puesto" class="form-control" placeholder="Ej. Desarrollador Senior" value="{{ old('puesto') }}">
                    <small class="error" id="errorPuesto"></small>
                </div>
                
                <div class="col-md-6">
                    <label>Departamento</label>
                    <select id="departamento" name="id_departamento" class="form-select">
                        <option value="">Seleccionar...</option>
                        {{-- IDs de ejemplo, ajusta estos a tu tabla 'departamentos' --}}
                        <option value="1" {{ old('id_departamento') == '1' ? 'selected' : '' }}>Soporte Técnico</option>
                        <option value="2" {{ old('id_departamento') == '2' ? 'selected' : '' }}>Ventas</option>
                        <option value="3" {{ old('id_departamento') == '3' ? 'selected' : '' }}>Producción</option>
                        <option value="4" {{ old('id_departamento') == '4' ? 'selected' : '' }}>Administración</option>
                    </select>
                    <small class="error" id="errorDepartamento"></small>
                </div>

                <div class="col-md-6">
                    <label>Foto de Perfil (Opcional)</label>
                    <input type="file" id="fotoPerfil" name="foto" class="form-control">
                    <small class="text-muted">Formatos: JPG, PNG, máx. 2MB</small>
                </div>
                
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-guardar px-4">Guardar Usuario</button>
            </div>
        </form>

        <hr class="my-5">

        <h4 class="mb-3">Lista de usuarios registrados</h4>
        <div class="table-responsive">
            <table class="table table-bordered tabla-usuarios">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Puesto</th> <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios">
                {{-- 1. Verifica si la variable $usuarios contiene datos --}}
                @if (!empty($usuarios))
                    
                    {{-- 2. Itera sobre cada usuario devuelto por el controlador --}}
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id_usuario }}</td> 
                            <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td> 
                            <td>{{ $usuario->correo }}</td>
                            
                            {{-- Muestra el NOMBRE DEL ROL usando la relación rol() --}}
                            <td>{{ $usuario->rol?->nombre_rol ?? 'N/A' }}</td> 
                            
                            <td>{{ $usuario->puesto }}</td> 
                            
                            {{-- Muestra el NOMBRE DEL DEPARTAMENTO usando la relación departamento() --}}
                            <td>{{ $usuario->departamento?->nombre_departamento ?? 'N/A' }}</td> 
                            
                            <td>
                                <button class="btn btn-sm btn-info text-white me-1">Editar</button> 
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                
                {{-- Si no hay usuarios en la base de datos, muestra un mensaje --}}
                @else
                    <tr>
                        <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                @endif
            </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    Sistema de Tickets &copy; 2023 Dulces Ricos.
</footer>

{{-- SE ELIMINA LA VALIDACIÓN DE JAVASCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>