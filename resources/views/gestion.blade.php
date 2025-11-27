<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Sistema de Tickets - Dulces Ricos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

        .error {
            color: red;
            font-size: 0.9em;
        }
        
        /* Estilo para el campo de contraseña con el ojo */
        .password-container {
            position: relative;
        }
        .password-container .form-control {
            padding-right: 2.5rem;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 100;
            color: #6c757d;
        }

        /* --- ESTILOS DE TABLA MEJORADOS Y BOTONES UNIFICADOS --- */

        .tabla-usuarios {
            border-radius: 10px; 
            overflow: hidden; 
            border-collapse: separate; 
            border-spacing: 0;
        }

        .tabla-usuarios th {
            background-color: #4e73df;
            color: white;
            font-weight: 600;
            padding: 12px 15px;
            text-align: left;
        }

        .tabla-usuarios thead tr th:first-child {
            border-top-left-radius: 10px;
        }
        .tabla-usuarios thead tr th:last-child {
            border-top-right-radius: 10px;
        }

        .tabla-usuarios td {
            background-color: #ffffff;
            padding: 12px 15px;
            color: #333;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0; 
        }

        /* Estilo Zebra para filas alternas */
        .tabla-usuarios tbody tr:nth-child(even) td {
            background-color: #f8f9fa; 
        }

        /* Efecto Hover */
        .tabla-usuarios tbody tr:hover td {
            background-color: #e9ecef; 
            transition: background-color 0.3s ease;
        }

        /* Quitar el borde inferior de la última fila */
        .tabla-usuarios tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Centrar Acciones */
        .tabla-usuarios td:last-child {
            text-align: center;
        }
        
        /* 💡 ESTILO NUEVO: UNIFICAR TAMAÑO Y COLOR DE BOTONES DE ACCIÓN */
        .btn-action {
            width: 80px; 
            padding: 5px 0; 
            text-align: center;
            margin-bottom: 2px;
            /* Fuerza el color para que sean más estables */
            font-size: 0.85rem; 
            font-weight: 600;
        }

        .btn-info {
            background-color: #4e73df !important;
            border-color: #4e73df !important;
        }
        .btn-danger {
            background-color: #e74a3b !important;
            border-color: #e74a3b !important;
        }
        /* --- FIN ESTILOS DE TABLA MEJORADOS Y BOTONES UNIFICADOS --- */


        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
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
        
        {{-- 2. BLOQUE PARA MOSTRAR ERRORES DE VALIDACIÓN (SERVER-SIDE) --}}
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

        <form id="formUsuario" method="POST" 
              action="{{ isset($usuario_editar) ? route('usuarios.update', $usuario_editar->id_usuario) : route('usuarios.store') }}" 
              enctype="multipart/form-data">
            
            @csrf
            
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

                {{-- CAMBIO CLAVE: Contenedor para el ojo de la contraseña --}}
                <div class="col-md-6">
                    <label>Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="{{ isset($usuario_editar) ? 'Dejar vacío para no cambiar' : 'Mínimo 6 caracteres' }}">
                        <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                    </div>
                    
                    <small class="text-muted">
                        {{ isset($usuario_editar) ? '(Opcional: Solo llena si quieres cambiarla)' : '' }}
                    </small>
                    {{-- Usamos el small de error aquí, después del text-muted --}}
                    <small class="error" id="errorPassword"></small> 
                </div>

                <div class="col-md-6">
                    <label>Rol</label>
                    <select id="rol" name="id_rol" class="form-select">
                        <option value="">Seleccionar...</option>
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
                            
                            {{-- AÑADIDA CLASE btn-action A AMBOS BOTONES --}}
                            <td>
                                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-sm btn-info text-white me-1 btn-action">
                                    Editar
                                </a> 
                                
                                <form action="{{ route('usuarios.desactivar', $usuario->id_usuario) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar (desactivar) a este usuario?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-danger btn-action">Eliminar</button>
                                </form>
                            </td>
                            {{-- FIN MODIFICACIÓN --}}
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

{{-- INICIO DEL SCRIPT DE VALIDACIÓN Y MOSTRAR CONTRASEÑA --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formUsuario');
    
    // Obtener campos y contenedores de error
    const nombre = document.getElementById('nombre');
    const apellido = document.getElementById('apellido');
    const correo = document.getElementById('correo');
    const password = document.getElementById('password');
    const rol = document.getElementById('rol');
    const puesto = document.getElementById('puesto');
    
    const errorNombre = document.getElementById('errorNombre');
    const errorApellido = document.getElementById('errorApellido');
    const errorCorreo = document.getElementById('errorCorreo');
    const errorRol = document.getElementById('errorRol');
    const errorPuesto = document.getElementById('errorPuesto');
    const errorPassword = document.getElementById('errorPassword'); 
    
    // REGEX para letras, espacios y guiones (debe coincidir con la de Laravel)
    const alphaRegex = /^[\p{L}\s\-]+$/u; 
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    // --- FUNCIÓN MOSTRAR/OCULTAR CONTRASEÑA ---
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            // Alternar el tipo de input entre 'password' y 'text'
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Alternar el icono del ojo
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }
    // ------------------------------------------

    // Función auxiliar para mostrar/ocultar errores
    function setError(element, errorElement, message) {
        if (message) {
            errorElement.textContent = message;
            element.classList.add('is-invalid');
            element.classList.remove('is-valid');
        } else {
            errorElement.textContent = '';
            element.classList.remove('is-invalid');
            element.classList.add('is-valid'); 
        }
    }

    // Función de validación para campos alfabéticos (Nombre, Apellido, Puesto)
    function validateAlphaField(input, errorContainer, fieldName) {
        const value = input.value.trim();
        
        if (value === '') {
            setError(input, errorContainer, `El ${fieldName} es obligatorio.`);
            return false;
        }
        if (value.length > 100) {
             setError(input, errorContainer, `El ${fieldName} no debe exceder los 100 caracteres.`);
             return false;
        }
        
        // Comprobar la REGEX para letras
        if (!alphaRegex.test(value)) {
             setError(input, errorContainer, `El ${fieldName} solo debe contener letras, espacios y guiones.`);
             return false;
        }
        
        setError(input, errorContainer, '');
        return true;
    }

    // Función de validación para el correo
    function validateEmail() {
        if (correo.value.trim() === '') {
            setError(correo, errorCorreo, 'El correo electrónico es obligatorio.');
            return false;
        }
        if (!emailRegex.test(correo.value.trim())) {
            setError(correo, errorCorreo, 'Por favor, introduce un correo electrónico válido (ej. correo@dominio.com).');
            return false;
        }
        setError(correo, errorCorreo, '');
        return true;
    }

    // Función de validación para el rol
    function validateRol() {
        if (rol.value === '') {
            setError(rol, errorRol, 'Debes seleccionar un Rol.');
            return false;
        }
        setError(rol, errorRol, '');
        return true;
    }

    // Función de validación para la contraseña
    function validatePassword() {
        const passwordField = password;
        
        const isEditMode = password.placeholder.includes('Dejar vacío');
        
        // Modo Creación: Contraseña obligatoria
        if (!isEditMode && passwordField.value === '') {
            setError(passwordField, errorPassword, 'La contraseña es obligatoria.'); 
            return false;
        }

        // Modo Edición o Creación, si hay valor, debe tener 6 caracteres
        if (passwordField.value !== '' && passwordField.value.length < 6) {
            setError(passwordField, errorPassword, 'La contraseña debe tener al menos 6 caracteres.');
            return false;
        }
        
        // Limpiar el error si es válido (o si está vacío en modo edición)
        passwordField.classList.remove('is-invalid');
        errorPassword.textContent = ''; 
        return true;
    }
    
    // Asignar eventos 'blur' (al salir del campo) para validación en tiempo real
    nombre.addEventListener('blur', () => validateAlphaField(nombre, errorNombre, 'Nombre'));
    apellido.addEventListener('blur', () => validateAlphaField(apellido, errorApellido, 'Apellido'));
    correo.addEventListener('blur', validateEmail);
    rol.addEventListener('change', validateRol);
    puesto.addEventListener('blur', () => validateAlphaField(puesto, errorPuesto, 'Puesto'));
    password.addEventListener('blur', validatePassword);

    
    // Validación al enviar el formulario
    form.addEventListener('submit', function(event) {
        // Ejecutar todas las validaciones
        const isNombreValid = validateAlphaField(nombre, errorNombre, 'Nombre');
        const isApellidoValid = validateAlphaField(apellido, errorApellido, 'Apellido');
        const isCorreoValid = validateEmail();
        const isRolValid = validateRol();
        const isPuestoValid = validateAlphaField(puesto, errorPuesto, 'Puesto');
        const isPasswordValid = validatePassword();
        
        // Si alguna validación falla, prevenimos el envío del formulario
        if (!isNombreValid || !isApellidoValid || !isCorreoValid || !isRolValid || !isPuestoValid || !isPasswordValid) {
            event.preventDefault();
            // Scroll al primer error
            const firstInvalid = document.querySelector('.is-invalid');
            if(firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>

</body>
</html>