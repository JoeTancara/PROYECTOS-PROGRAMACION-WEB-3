<?php

include '../conexion.php';
$id=$_POST['id'];

$queey = "DELETE FROM usuarios  WHERE id=$id";

$conn->query($queey);
header('Location: ../index.php');
?>