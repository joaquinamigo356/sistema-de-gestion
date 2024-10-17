<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Verificar si se han recibido los datos del formulario
    if (isset($_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['perfil'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $correo = $conn->real_escape_string($_POST['correo']);
        $perfil = $conn->real_escape_string($_POST['perfil']);

        // Consulta de inserción de datos
        $sql = "INSERT INTO usuarios (id, nombre, apellido, correo, perfil) VALUES ('$id', '$nombre', '$apellido', '$correo', '$perfil')";

        // Ejecutar la consulta e informar sobre el resultado
        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error al registrar usuario: " . $conn->error;
        }
    } else {
        echo "Por favor, completa todos los campos del formulario.";
    }

    // Cerrar la conexión
    $conn->close();

    // Redirigir de nuevo a la página de usuarios
    header("Location: usuarios.html");
    exit();
} else {
    echo "Solicitud inválida.";
}
?>
       
