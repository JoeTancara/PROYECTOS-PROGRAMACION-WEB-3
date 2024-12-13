<?php

include '../conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

$query="UPDATE usuarios SET nombre='$nombre', correo='$correo', telefono='$telefono' WHERE id=$id";

$conn->query($query);
header('Location: ../index.php');
?>
