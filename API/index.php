<?php
$request = $_GET['request'];

switch (true) {
    case preg_match('/^usuarios/', $request):
        include 'usuarios.php';
        break;
    case preg_match('/^asistencias/', $request):
        include 'asistencias.php';
        break;
    default:
        echo json_encode(['error' => 'Ruta no encontrada.']);
        break;
}
?>
