<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levantar Ticket de Soporte</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
</head>
<body>
    <x-navbar />

    <div class="ticket-form-container">
        <div class="ticket-header">
            <h2>Levantar Ticket de Soporte</h2>
        </div>

        <div class="ticket-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre del empleado</label>
                    <input type="text" id="nombre" name="nombre" value="Isabel Navarrete" readonly>
                </div>

                <div class="form-group">
                    <label for="puesto">Puesto</label>
                    <input type="text" id="puesto" name="puesto" value="Asistente Administrativa" readonly>
                </div>
                <div class="form-group">
                    <label for="titulo">Título del problema</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ejemplo: No puedo imprimir" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción detallada</label>
                    <textarea id="descripcion" name="descripcion" rows="5" placeholder="Describe tu problema con detalle..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="prioridad">Prioridad</label>
                    <select id="prioridad" name="prioridad" required>
                        <option value="">Selecciona una prioridad</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="archivo">Adjuntar evidencia (opcional)</label>
                    <input type="file" id="archivo" name="archivo" accept="image/*,.pdf">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-enviar">Enviar Ticket</button>
                    <button type="reset" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
