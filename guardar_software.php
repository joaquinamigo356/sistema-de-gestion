<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gestion_usuarios";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    if (isset($_POST['nombre'], $_POST['version'], $_POST['licencia'], $_POST['id_usuario'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $version = $conn->real_escape_string($_POST['version']);
        $licencia = $conn->real_escape_string($_POST['licencia']);
        $id_usuario = $conn->real_escape_string($_POST['id_usuario']);

        if (!empty($_POST['softwareID'])) {
            $softwareID = $conn->real_escape_string($_POST['softwareID']);
            $sql = "UPDATE software SET nombre='$nombre', version='$version', licencia='$licencia', id_usuario='$id_usuario' WHERE id='$softwareID'";
        } else {
            $sql = "INSERT INTO software (nombre, version, licencia, id_usuario) VALUES ('$nombre', '$version', '$licencia', '$id_usuario')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Software guardado con éxito.";
        } else {
            echo "Error al guardar software: " . $conn->error;
        }
    } else {
        echo "Completa todos los campos obligatorios.";
    }

    $conn->close();
    header("Location: software.php");
    exit();
}
?>
