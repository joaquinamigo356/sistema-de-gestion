<?php
if (isset($_GET['id'])) {
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';

    // Crear conexión
    $conn = new mysqli($server, $user, $pass, $db);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM usuarios WHERE id=$id";

    // Ejecutar la consulta y verificar el resultado
    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}

// Redirigir de vuelta a la página principal de usuarios
header("Location: usuarios.html");
exit();
?>
