<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Sistema de Tickets - Dulces Ricos</title>

    <!-- Bootstrap y fuente -->
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
        <form id="formUsuario">
            <div class="row g-4">
                <div class="col-md-6">
                    <label>Nombre completo</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ej. Ana Martínez">
                    <small class="error" id="errorNombre"></small>
                </div>

                <div class="col-md-6">
                    <label>Correo electrónico</label>
                    <input type="email" id="correo" class="form-control" placeholder="Ej. ana@example.com">
                    <small class="error" id="errorCorreo"></small>
                </div>

                <div class="col-md-6">
                    <label>Contraseña</label>
                    <input type="password" id="password" class="form-control" placeholder="Mínimo 6 caracteres">
                    <small class="error" id="errorPassword"></small>
                </div>

                <div class="col-md-6">
                    <label>Teléfono</label>
                    <input type="text" id="telefono" class="form-control" placeholder="Ej. 5512345678">
                    <small class="error" id="errorTelefono"></small>
                </div>

                <div class="col-md-6">
                    <label>Rol</label>
                    <select id="rol" class="form-select">
                        <option value="">Seleccionar...</option>
                        <option>Empleado</option>
                        <option>Supervisor</option>
                        <option>Jefe</option>
                    </select>
                    <small class="error" id="errorRol"></small>
                </div>

                <div class="col-md-6">
                    <label>Departamento</label>
                    <select id="departamento" class="form-select">
                        <option value="">Seleccionar...</option>
                        <option>Soporte Técnico</option>
                        <option>Ventas</option>
                        <option>Producción</option>
                        <option>Administración</option>
                    </select>
                    <small class="error" id="errorDepartamento"></small>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-guardar px-4">Guardar Usuario</button>
                <button type="reset" class="btn btn-outline-secondary px-4 ms-2">Limpiar</button>
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
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios">
                    <tr>
                        <td>1</td>
                        <td>Ana Martínez</td>
                        <td>ana@example.com</td>
                        <td>Empleado</td>
                        <td>Ventas</td>
                        <td><button class="btn btn-sm btn-danger">Eliminar</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Carlos Ruiz</td>
                        <td>carlos@example.com</td>
                        <td>Supervisor</td>
                        <td>Producción</td>
                        <td><button class="btn btn-sm btn-danger">Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
document.getElementById("formUsuario").addEventListener("submit", function(e){
    e.preventDefault();

    let valido = true;

    // Limpiar errores previos
    document.querySelectorAll(".error").forEach(e => e.textContent = "");

    const nombre = document.getElementById("nombre").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("password").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const rol = document.getElementById("rol").value;
    const departamento = document.getElementById("departamento").value;

    if(nombre === ""){
        document.getElementById("errorNombre").textContent = "El nombre es obligatorio.";
        valido = false;
    }

    const regexCorreo = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
    if(!regexCorreo.test(correo)){
        document.getElementById("errorCorreo").textContent = "Correo no válido.";
        valido = false;
    }

    if(password.length < 6){
        document.getElementById("errorPassword").textContent = "Debe tener al menos 6 caracteres.";
        valido = false;
    }

    const regexTel = /^[0-9]{10}$/;
    if(!regexTel.test(telefono)){
        document.getElementById("errorTelefono").textContent = "Teléfono no válido (10 dígitos).";
        valido = false;
    }

    if(rol === ""){
        document.getElementById("errorRol").textContent = "Selecciona un rol.";
        valido = false;
    }

    if(departamento === ""){
        document.getElementById("errorDepartamento").textContent = "Selecciona un departamento.";
        valido = false;
    }

    if(valido){
        alert("Usuario registrado correctamente (simulado)");
        document.getElementById("formUsuario").reset();
    }
});
</script>

</body>
</html>
