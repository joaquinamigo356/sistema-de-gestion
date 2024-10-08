<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Datos de conexión a la base de datos
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';

    // Crear la conexión a la base de datos
    $conn = new mysqli($server, $user, $pass, $db);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener los datos enviados desde el formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $perfil = $conn->real_escape_string($_POST['perfil']);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, perfil) VALUES ('$nombre', '$apellido', '$correo', '$perfil')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar usuario: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();

    // Redirigir de nuevo a la página de usuarios
    header("Location: usuarios.html");
    exit();
}
?>


