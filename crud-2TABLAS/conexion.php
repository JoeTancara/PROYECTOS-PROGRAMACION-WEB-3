
<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'crudweb3';

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die('erro:'.$con->connect_error);
}

?>