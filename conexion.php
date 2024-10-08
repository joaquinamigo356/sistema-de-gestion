<?php
// Datos de conexión a la base de datos
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'gestion_usuarios';

function connection(){
// Crear la conexión
$conn = new mysqli($server, $user, $pass, $db);


// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
mysqli_select_db($connect,$db);
return $connect;
}
?>
