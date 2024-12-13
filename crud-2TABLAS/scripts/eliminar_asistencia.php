<?php
include '../conexion.php';
$id = $_POST['id'];

$query = "DELETE FROM asistencias WHERE id=$id";
$conn->query($query);
header('Location: ../index.php');
?>
