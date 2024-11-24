<?php
require 'config/Database.php';
require 'classes/CRUD.php';

$db = new Database();
$conn = $db->getConnection();
$crud = new CRUD($conn);

// Obtener el ID de la tarea a editar
$id = $_GET['id'];
$tarea = $crud->obtenerTareas();
$tareaActual = null;

// Buscar la tarea por su ID
foreach ($tarea as $t) {
    if ($t['id'] == $id) {
        $tareaActual = $t;
        break;
    }
}

// Si el formulario es enviado, actualizamos la tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevaTarea = $_POST['tarea'];
    $descripcion = $_POST['descripcion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $estado = $_POST['estado'];

    // Llamada al método para actualizar la tarea
    $resultado = $crud->actualizarTarea($id, $nuevaTarea, $descripcion, $fecha_vencimiento, $estado);

    // Redirección con mensajes usando parámetros GET
    if ($resultado === true) {
        header("Location: index.php?alert=success&message=Tarea editada exitosamente.");
        exit();
    } else {
        header("Location: index.php?alert=error&message=Error al actualizar la tarea.");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Tarea</h2>
        <?php if ($tareaActual): ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="tarea" class="form-label">Tarea</label>
                    <input type="text" class="form-control" id="tarea" name="tarea" value="<?= $tareaActual['tarea'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= $tareaActual['descripcion'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?= $tareaActual['fecha_vencimiento'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="pendiente" <?= ($tareaActual['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="completado" <?= ($tareaActual['estado'] == 'completado') ? 'selected' : ''; ?>>Completado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php else: ?>
            <p>Tarea no encontrada.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>
    <script>
        // Verifica si hay mensajes en los parámetros de la URL
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            const alertType = urlParams.get('alert'); // success, error
            const alertMessage = urlParams.get('message');

            if (alertType && alertMessage) {
                if (alertType === 'success') {
                    alertify.success(alertMessage);
                } else if (alertType === 'error') {
                    alertify.error(alertMessage);
                }
            }
        };
    </script>
</body>
</html>
