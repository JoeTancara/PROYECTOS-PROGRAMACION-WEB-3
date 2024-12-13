<?php
include '../conexion.php';
$id = $_POST['id'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];

$query = "UPDATE asistencias SET fecha='$fecha', estado='$estado' WHERE id=$id";
$conn->query($query);
header('Location: ../index.php');
?>
