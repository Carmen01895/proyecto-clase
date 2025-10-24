<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets | Sistema de Tickets - Dulces Ricos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f3f6fb;
            font-family: 'Poppins', sans-serif;
        }

        .panel-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1200px;
            margin: 30px auto;
        }

        .panel-header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .foto-perfil {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
            position: absolute;
            right: 30px;
            top: 30px;
            background-color: white;
        }

        .panel-body {
            padding: 30px;
        }

        .btn-nuevo {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-nuevo:hover {
            background-color: #3a5fc8;
        }

        .btn-cancelar {
            background-color: #e74a3b;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-cancelar:hover {
            background-color: #d52a1a;
        }

        .btn-cancelar:disabled {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .estado-pendiente {
            background-color: #fcefc7;
            color: #946c00;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .estado-proceso {
            background-color: #cce7ff;
            color: #0066cc;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .estado-resuelto {
            background-color: #d1f7c4;
            color: #0d6b0d;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .estado-cancelado {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .tabla-tickets {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .tabla-tickets thead {
            background-color: #4e73df;
            color: white;
        }

        .tabla-tickets th {
            font-weight: 600;
            padding: 15px;
        }

        .tabla-tickets td {
            padding: 15px;
            vertical-align: middle;
        }

        .tabla-tickets tbody tr:hover {
            background-color: #f8f9fa;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }

        .badge-ticket {
            background-color: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
        }

        .filtros {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php
// Función para obtener la clase CSS según el estado
function obtenerClaseEstado($estado) {
    switch($estado) {
        case 'pendiente': return 'estado-pendiente';
        case 'proceso': return 'estado-proceso';
        case 'resuelto': return 'estado-resuelto';
        case 'cancelado': return 'estado-cancelado';
        default: return 'estado-pendiente';
    }
}

// Función para obtener el texto del estado
function obtenerTextoEstado($estado) {
    switch($estado) {
        case 'pendiente': return 'Pendiente';
        case 'proceso': return 'En proceso';
        case 'resuelto': return 'Resuelto';
        case 'cancelado': return 'Cancelado';
        default: return 'Pendiente';
    }
}

// Procesar cancelación de ticket si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_ticket'])) {
    $ticket_id = $_POST['ticket_id'];
    // Aquí iría la lógica para actualizar el estado en la base de datos
    $mensaje = "El ticket $ticket_id ha sido cancelado exitosamente.";
}
?>

<div class="panel-card">
    <div class="panel-header">
        <h2>Mis Tickets</h2>
        <p>Visualiza el historial y estado de tus tickets</p>
        <img src="images/perfil.jpg" alt="Foto de perfil" class="foto-perfil">
    </div>

    <div class="panel-body">
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Listado de Tickets</h4>
            <a href="{{ route('tickets.create') }}" class="btn btn-nuevo">
                <i class="bi bi-plus-circle"></i> Nuevo Ticket
            </a>
        </div>

        <!-- Filtros -->
        <div class="filtros">
            <form method="GET" action="">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Filtrar por estado:</label>
                        <select class="form-select" name="filtro_estado" onchange="this.form.submit()">
                            <option value="todos" <?php echo (!isset($_GET['filtro_estado']) || $_GET['filtro_estado'] == 'todos') ? 'selected' : ''; ?>>Todos los estados</option>
                            <option value="pendiente" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="proceso" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'proceso') ? 'selected' : ''; ?>>En proceso</option>
                            <option value="resuelto" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'resuelto') ? 'selected' : ''; ?>>Resuelto</option>
                            <option value="cancelado" <?php echo (isset($_GET['filtro_estado']) && $_GET['filtro_estado'] == 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Buscar por ID:</label>
                        <input type="text" class="form-control" name="buscar_id" placeholder="Ej: TKT-001" value="<?php echo isset($_GET['buscar_id']) ? htmlspecialchars($_GET['buscar_id']) : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ordenar por:</label>
                        <select class="form-select" name="ordenar_por" onchange="this.form.submit()">
                            <option value="fecha-desc" <?php echo (!isset($_GET['ordenar_por']) || $_GET['ordenar_por'] == 'fecha-desc') ? 'selected' : ''; ?>>Fecha (más reciente)</option>
                            <option value="fecha-asc" <?php echo (isset($_GET['ordenar_por']) && $_GET['ordenar_por'] == 'fecha-asc') ? 'selected' : ''; ?>>Fecha (más antigua)</option>
                            <option value="estado" <?php echo (isset($_GET['ordenar_por']) && $_GET['ordenar_por'] == 'estado') ? 'selected' : ''; ?>>Estado</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de tickets -->
        <div class="table-responsive">
            <table class="table tabla-tickets">
                <thead>
                    <tr>
                        <th>ID Ticket</th>
                        <th>Fecha</th>
                        <th>Asunto</th>
                        <th>Asignado a</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los tickets se cargarán aquí dinámicamente desde la base de datos -->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav aria-label="Navegación de páginas">
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<footer>
    Sistema de Gestión de Tickets © Dulces Ricos | Desarrollado por Fanny Alegría
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>