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

<x-navbar />

<div class="usuarios-card">
    <div class="usuarios-header">
        <h2>Gestión de Usuarios</h2>
        <p>Administrar las cuentas de los empleados</p>
    </div>

    <div class="usuarios-body">
        <h4 class="mb-4">
            {{ isset($usuario_editar) ? 'Editar Usuario: ' . $usuario_editar->nombre : 'Registrar nuevo usuario' }}
        </h4>

        {{-- 1. BLOQUE PARA MOSTRAR MENSAJES DE ÉXITO --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        {{-- 2. BLOQUE PARA MOSTRAR ERRORES DE VALIDACIÓN --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Por favor, corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 
            FORMULARIO INTELIGENTE:
            - Si existe $usuario_editar, la acción es UPDATE (Editar).
            - Si no existe, la acción es STORE (Crear).
        --}}
        <form id="formUsuario" method="POST" 
              action="{{ isset($usuario_editar) ? route('usuarios.update', $usuario_editar->id_usuario) : route('usuarios.store') }}" 
              enctype="multipart/form-data">
            
            @csrf
            
            {{-- Si estamos editando, agregamos el método PUT que exige Laravel --}}
            @if(isset($usuario_editar))
                @method('PUT')
            @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <label>Nombre(s)</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" 
                           placeholder="Ej. Ana" 
                           value="{{ old('nombre', $usuario_editar->nombre ?? '') }}">
                    <small class="error" id="errorNombre"></small>
                </div>

                <div class="col-md-6">
                    <label>Apellido(s)</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" 
                           placeholder="Ej. Martínez" 
                           value="{{ old('apellido', $usuario_editar->apellido ?? '') }}">
                    <small class="error" id="errorApellido"></small>
                </div>

                <div class="col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" id="correo" name="email" class="form-control" 
                           placeholder="Ej. ana@example.com" 
                           value="{{ old('email', $usuario_editar->correo ?? '') }}">
                    <small class="error" id="errorCorreo"></small>
                </div>

                <div class="col-md-6">
                    <label>Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="{{ isset($usuario_editar) ? 'Dejar vacío para no cambiar' : 'Mínimo 6 caracteres' }}">
                    <small class="text-muted">
                        {{ isset($usuario_editar) ? '(Opcional: Solo llena si quieres cambiarla)' : '' }}
                    </small>
                </div>

                <div class="col-md-6">
                    <label>Rol</label>
                    <select id="rol" name="id_rol" class="form-select">
                        <option value="">Seleccionar...</option>
                        {{-- Comparamos con old() o con el valor de la base de datos --}}
                        <option value="3" {{ old('id_rol', $usuario_editar->id_rol ?? '') == 3 ? 'selected' : '' }}>Empleado</option>
                        <option value="2" {{ old('id_rol', $usuario_editar->id_rol ?? '') == 2 ? 'selected' : '' }}>Jefe</option>
                        <option value="1" {{ old('id_rol', $usuario_editar->id_rol ?? '') == 1 ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <small class="error" id="errorRol"></small>
                </div>

                <div class="col-md-6">
                    <label>Puesto</label>
                    <input type="text" id="puesto" name="puesto" class="form-control" 
                           placeholder="Ej. Desarrollador Senior" 
                           value="{{ old('puesto', $usuario_editar->puesto ?? '') }}">
                    <small class="error" id="errorPuesto"></small>
                </div>
                
                <div class="col-md-6">
                    <label>Departamento</label>
                    <select id="departamento" name="id_departamento" class="form-select">
                        <option value="">Seleccionar...</option>
                        {{-- Este bucle crea la lista automáticamente --}}
                        @foreach($departamentos as $depto)
                            <option value="{{ $depto->id_departamento }}"

                                {{ old('id_departamento', $usuario_editar->id_departamento ?? '') == $depto->id_departamento ? 'selected' : '' }}>
                                {{ $depto->nombre_departamento }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Foto de Perfil (Opcional)</label>
                    <input type="file" id="fotoPerfil" name="foto" class="form-control">
                    @if(isset($usuario_editar) && $usuario_editar->foto_perfil)
                        <small class="text-success">Actualmente tienes una foto cargada.</small>
                    @else
                        <small class="text-muted">Formatos: JPG, PNG, máx. 2MB</small>
                    @endif
                </div>
                
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-guardar px-4">
                    {{ isset($usuario_editar) ? 'Actualizar Usuario' : 'Guardar Usuario' }}
                </button>

                {{-- Botón Cancelar solo aparece si estamos editando --}}
                @if(isset($usuario_editar))
                    <a href="{{ route('gestion') }}" class="btn btn-secondary px-4 ms-2">Cancelar Edición</a>
                @endif
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
                        <th>Puesto</th> 
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios">
                @if (!empty($usuarios) && $usuarios->count() > 0)
                    
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id_usuario }}</td> 
                            <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td> 
                            <td>{{ $usuario->correo }}</td>
                            
                            <td>{{ $usuario->rol?->nombre_rol ?? 'N/A' }}</td> 
                            
                            <td>{{ $usuario->puesto }}</td> 
                            
                            <td>{{ $usuario->departamento?->nombre_departamento ?? 'N/A' }}</td> 
                            
                            <td>
                                {{-- BOTÓN EDITAR: Recarga la página con los datos en el formulario --}}
                                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-sm btn-info text-white me-1">
                                    Editar
                                </a> 
                                
                                {{-- BOTÓN ELIMINAR (Desactivar): Usa un formulario oculto por seguridad --}}
                                <form action="{{ route('usuarios.desactivar', $usuario->id_usuario) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar (desactivar) a este usuario?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                
                @else
                    <tr>
                        <td colspan="7" class="text-center">No hay usuarios activos registrados.</td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>