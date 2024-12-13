<?php
    require_once "models/Empleado.php";

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Obtener un empleado por su ID
            if (isset($_GET['id'])) {
                echo json_encode(Empleado::getWhere($_GET['id']));
            } else {
                // Obtener todos los empleados
                echo json_encode(Empleado::getAll());
            }
            break;

        case 'POST':
            // Insertar un nuevo empleado
            $datos = json_decode(file_get_contents('php://input'));
            if ($datos != NULL) {
                if (Empleado::insert($datos->nombre, $datos->cargo, $datos->fecha_ingreso)) {
                    http_response_code(200);  // Respuesta exitosa
                } else {
                    http_response_code(400);  // Error en la inserción
                }
            } else {
                http_response_code(405);  // Método no permitido
            }
            break;

        case 'PUT':
            // Actualizar los datos de un empleado
            $datos = json_decode(file_get_contents('php://input'));
            if ($datos != NULL) {
                if (Empleado::update($datos->id_empleado, $datos->nombre, $datos->cargo, $datos->fecha_ingreso)) {
                    http_response_code(200);  // Respuesta exitosa
                } else {
                    http_response_code(400);  // Error en la actualización
                }
            } else {
                http_response_code(405);  // Método no permitido
            }
            break;

        case 'DELETE':
            // Eliminar un empleado por su ID
            if (isset($_GET['id'])) {
                if (Empleado::delete($_GET['id'])) {
                    http_response_code(200);  // Respuesta exitosa
                } else {
                    http_response_code(400);  // Error en la eliminación
                }
            } else {
                http_response_code(405);  // Método no permitido
            }
            break;

        default:
            http_response_code(405);  // Método no permitido
            break;
    }
?>
