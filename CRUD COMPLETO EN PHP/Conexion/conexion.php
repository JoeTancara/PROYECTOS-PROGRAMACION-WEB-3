<?php
$servername = "mysql:dbname=crud;host=127.0.0.1";
$username = "root";
$password = "";

try {
  $conn = new PDO($servername, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
  //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection mala: " . $e->getMessage();
}
?>