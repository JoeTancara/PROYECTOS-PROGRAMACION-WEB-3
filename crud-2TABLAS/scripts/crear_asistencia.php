<?php
include '../conexion.php';
$usuario_id = $_POST['usuario_id'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];

$query = "INSERT INTO asistencias (usuario_id, fecha, estado) VALUES ('$usuario_id', '$fecha', '$estado')";
$conn->query($query);
header('Location: ../index.php');
?>
