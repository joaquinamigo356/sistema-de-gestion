<?php

 // Verificar si la solicitud es POST
if (($_SERVER['REQUEST_METHOD'] ??'') === 'POST') {
    // Configuración de la base de datos
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';

    // Incluir la conexión a la base de datos
    include('conexion.php');

    // Escapar el ID recibido
    $id = $conn->real_escape_string($_POST['id']);

    // Imprimir el ID del usuario
    echo "ID del usuario: $id";

    // Preparar la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = $id";

    // Ejecutar la consulta y verificar el resultado
    $resultado = $conn->query($sql);
    if ($resultado === TRUE) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    // Imprimir el resultado de la consulta SQL
    echo "Resultado de la consulta SQL: ";
    var_dump($resultado);

    // Cerrar la conexión
    $conn->close();

    // Redirigir a la página de usuarios
    header("Location: usuarios.html");
    exit();
}

?>
