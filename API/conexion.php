<?php
$host='localhost';
$user = 'root';
$pass='';
$dbname= 'crudweb3';


$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("conexion faliida:".$conn->connect_error);
}

header("Content-Type: application/json");
?>