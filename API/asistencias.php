<?php
include 'conexion.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT asistencias.*, usuarios.nombre AS usuario 
                      FROM asistencias 
                      INNER JOIN usuarios ON asistencias.usuario_id = usuarios.id 
                      WHERE asistencias.id = $id";
            $result = $conn->query($query);
            $asistencia = $result->fetch_assoc();
            echo json_encode($asistencia);
        } else {
            $query = "SELECT asistencias.*, usuarios.nombre AS usuario 
                      FROM asistencias 
                      INNER JOIN usuarios ON asistencias.usuario_id = usuarios.id";
            $result = $conn->query($query);
            $asistencias = [];
            while ($row = $result->fetch_assoc()) {
                $asistencias[] = $row;
            }
            echo json_encode($asistencias);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $usuario_id = $data['usuario_id'];
        $fecha = $data['fecha'];
        $estado = $data['estado'];

        $query = "INSERT INTO asistencias (usuario_id, fecha, estado) VALUES ('$usuario_id', '$fecha', '$estado')";
        if ($conn->query($query)) {
            echo json_encode(['message' => 'Asistencia registrada exitosamente.']);
        } else {
            echo json_encode(['error' => 'Error al registrar asistencia.']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $fecha = $data['fecha'];
        $estado = $data['estado'];

        $query = "UPDATE asistencias SET fecha='$fecha', estado='$estado' WHERE id=$id";
        if ($conn->query($query)) {
            echo json_encode(['message' => 'Asistencia actualizada exitosamente.']);
        } else {
            echo json_encode(['error' => 'Error al actualizar asistencia.']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $query = "DELETE FROM asistencias WHERE id = $id";
        if ($conn->query($query)) {
            echo json_encode(['message' => 'Asistencia eliminada exitosamente.']);
        } else {
            echo json_encode(['error' => 'Error al eliminar asistencia.']);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no permitido.']);
        break;
}
?>
