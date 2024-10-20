<?php
if (($_SERVER['REQUEST_METHOD'] ??'') === 'POST') {
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';

    $conn = new mysqli($server, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    
    if (isset($_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['perfil'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $correo = $conn->real_escape_string($_POST['correo']);
        $perfil = $conn->real_escape_string($_POST['perfil']);

        $sql = "INSERT INTO usuarios (id, nombre, apellido, correo, perfil) VALUES ('$id', '$nombre', '$apellido', '$correo', '$perfil')";

    
        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error al registrar usuario: " . $conn->error;
        }
    } else {
        echo "Por favor, completa todos los campos del formulario.";
    }

   
    $conn->close();

    header("Location: usuarios.html");
    exit();
} else {
    echo "Solicitud inválida.";
}
?>
