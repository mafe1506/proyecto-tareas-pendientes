<?php
// Incluye los archivos de configuración y clases
require 'config/Database.php';
require 'classes/CRUD.php';

// Establece la conexión a la base de datos
$db = new Database();
$conn = $db->getConnection();

// Crea una instancia del CRUD para manejar las operaciones de la base de datos
$crud = new CRUD($conn);

// Obtiene todas las tareas de la base de datos
$tareas = $crud->obtenerTareas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Enlaza el archivo CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Alertify.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
</head>
<body class="body">
    <header class="header">
        <h1>Control de Tareas de Mafe</h1>
    </header>

    <div class="container mt-5">
        <h2>Control de Tareas Pendientes</h2>
        
        <!-- Botón para agregar nueva tarea -->
        <a href="crear.php" class="btn btn-primary mb-3">Nueva Tarea</a>
        
        <!-- Tabla que muestra las tareas -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Itera sobre todas las tareas y las muestra en la tabla -->
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?= $tarea['id'] ?></td>
                        <td><?= $tarea['tarea'] ?></td>
                        <td><?= $tarea['descripcion'] ?></td>
                        <td><?= $tarea['fecha_vencimiento'] ?></td>
                        <td><?= ucfirst($tarea['estado']) ?></td>
                        <td>
                            <!-- Botones para editar y eliminar una tarea -->
                            <a href="editar.php?id=<?= $tarea['id'] ?>" class="btn btn-warning btn-sm">Editar</a> 
                            <br/>
                            <a href="eliminar.php?id=<?= $tarea['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5 py-3 bg-dark text-white text-center">
        <p>&copy; 2024 Mafe. Todos los derechos reservados.</p>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Alertify.js -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        // Verifica si hay un mensaje en la URL (por ejemplo, success o error)
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const alertType = urlParams.get('alert'); // success, error, etc.
            const alertMessage = urlParams.get('message'); // El mensaje de alerta

            if (alertType && alertMessage) {
                // Usa Alertify.js para mostrar el mensaje
                if (alertType === 'success') {
                    alertify.success(alertMessage);
                } else if (alertType === 'error') {
                    alertify.error(alertMessage);
                }
            }
        }
    </script>
</body>
</html>
