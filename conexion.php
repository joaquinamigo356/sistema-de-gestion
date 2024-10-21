<?php

$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'gestion_usuarios';

function connection(){

$conn = new mysqli($server, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
mysqli_select_db($connect,$db);
return $connect;
}
?>
