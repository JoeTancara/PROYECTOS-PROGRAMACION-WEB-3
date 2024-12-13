<?php
require_once "models/Asistencia.php";

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$segments = explode('/', trim($requestUri, '/'));

$resource = $segments[1];
$id = isset($segments[2]) ? $segments[2] : null;

if ($resource === 'asistencias') {
    switch ($method) {
        case 'GET':
            if ($id) {
                echo json_encode(Asistencia::getWhere($id));
            } else {
                echo json_encode(Asistencia::getAll());
            }
            break;

        case 'POST':
            $datos = json_decode(file_get_contents('php://input'));
            if ($datos != NULL) {
                if (Asistencia::insert($datos->id_empleado, $datos->fecha, $datos->estado)) {
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
                if (Asistencia::update($datos->id_asistencia, $datos->id_empleado, $datos->fecha, $datos->estado)) {
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
                if (Asistencia::delete($id)) {
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
