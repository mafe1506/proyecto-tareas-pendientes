<?php

class CRUD {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create
    public function crearTarea($tarea, $descripcion, $fecha_vencimiento, $estado) {
        try {
            $query = "INSERT INTO tareas (tarea, descripcion, fecha_vencimiento, estado) 
                      VALUES (:tarea, :descripcion, :fecha_vencimiento, :estado)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tarea', $tarea);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Read
    public function obtenerTareas() {
        $query = "SELECT * FROM tareas ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update
    public function actualizarTarea($id, $tarea, $descripcion, $fecha_vencimiento, $estado) {
        try {
            $query = "UPDATE tareas SET tarea = :tarea, descripcion = :descripcion, 
                      fecha_vencimiento = :fecha_vencimiento, estado = :estado WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':tarea', $tarea);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    // Delete
    public function eliminarTarea($id) {
        try {
            $query = "DELETE FROM tareas WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
