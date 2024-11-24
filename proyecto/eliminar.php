<?php
// Incluye los archivos de configuración y clases
require 'config/Database.php';
require 'classes/CRUD.php';

// Establece la conexión a la base de datos
$db = new Database();
$conn = $db->getConnection();
$crud = new CRUD($conn);

// Obtiene el ID de la tarea a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Llama al método para eliminar la tarea
    $resultado = $crud->eliminarTarea($id);

    // Verifica si la eliminación fue exitosa
    if ($resultado === true) {
        // Redirige con un mensaje de éxito
        header("Location: index.php?alert=success&message=Tarea eliminada exitosamente.");
    } else {
        // Redirige con un mensaje de error
        header("Location: index.php?alert=error&message=Error al eliminar la tarea.");
    }
} else {
    // Si no se encuentra un ID, redirige a la página principal con un mensaje de error
    header("Location: index.php?alert=error&message=Tarea no encontrada.");
}
exit();
?>
