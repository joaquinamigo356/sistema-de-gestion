<?php
if (($_SERVER['REQUEST_METHOD'] ??'') === 'POST') {
    
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';

    
    include('conexion.php');


    $id = $conn->real_escape_string($_POST['id']);

    
    echo "ID del usuario: $id";
  
    $sql = "DELETE FROM usuarios WHERE id = $id";

    $resultado = $conn->query($sql);
    if ($resultado === TRUE) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    
    echo "Resultado de la consulta SQL: ";
    var_dump($resultado);


    $conn->close();

    header("Location: usuarios.html");
    exit();
}

?>
