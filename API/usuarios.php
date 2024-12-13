<?php
include 'conexion.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM usuarios WHERE id = $id";
            $result = $conn->query($query);
            $usuario = $result->fetch_assoc();
            echo json_encode($usuario);
        } else {
            $query = "SELECT * FROM usuarios";
            $result = $conn->query($query);
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
            echo json_encode($usuarios);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $telefono = $data['telefono'];

        $query = "INSERT INTO usuarios (nombre, correo, telefono, rol_id) VALUES ('$nombre', '$correo', '$telefono')";
        if ($conn->query($query)) {
            echo json_encode(['message' => 'Usuario creado exitosamente.']);
        } else {
            echo json_encode(['error' => 'Error al crear usuario.']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $telefono = $data['telefono'];

        $query = "UPDATE usuarios SET nombre='$nombre', correo='$correo', telefono='$telefono' WHERE id=$id";
        if ($conn->query($query)) {
            echo json_encode(['message' => 'Usuario actualizado exitosamente.']);
        } else {
            echo json_encode(['error' => 'Error al actualizar usuario.']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $query = "DELETE FROM usuarios WHERE id = $id";
        if ($conn->query($query)) {
            echo json_encode(['message' => 'Usuario eliminado exitosamente.']);
        } else {
            echo json_encode(['error' => 'Error al eliminar usuario.']);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no permitido.']);
        break;
}
?>
