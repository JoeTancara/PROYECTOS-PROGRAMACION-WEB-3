<?php
require_once "models/Empleado.php";

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$segments = explode('/', trim($requestUri, '/'));

$resource = $segments[1];
$id = isset($segments[2]) ? $segments[2] : null;

if ($resource === 'empleados') {
    switch ($method) {
        case 'GET':
            if ($id) {
                echo json_encode(Empleado::getWhere($id));
            } else {
                echo json_encode(Empleado::getAll());
            }
            break;

        case 'POST':
            $datos = json_decode(file_get_contents('php://input'));
            if ($datos != NULL) {
                if (Empleado::insert($datos->nombre, $datos->ApellidoP, $datos->ApellidoM, $datos->genero)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }
            } else {
                http_response_code(405);  // Método no permitido
            }
            break;

        case 'PUT':
            $datos = json_decode(file_get_contents('php://input'));
            if ($datos != NULL) {
                if (Empleado::update($datos->id, $datos->nombre, $datos->ApellidoP, $datos->ApellidoM, $datos->genero)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }
            } else {
                http_response_code(405);  // Método no permitido
            }
            break;

        case 'DELETE':
            if ($id) {
                if (Empleado::delete($id)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }
            } else {
                http_response_code(405);  // Método no permitido
            }
            break;

        default:
            http_response_code(405);  // Método no permitido
            break;
    }
} else {
    http_response_code(404);  // No encontrado
}
?>
