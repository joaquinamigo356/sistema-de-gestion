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

    if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['cantidad'], $_POST['computador'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $cantidad = $conn->real_escape_string($_POST['cantidad']);
        $computador_id = $conn->real_escape_string($_POST['computador']);

        if (!empty($_POST['repuestoID'])) {
            $repuestoID = $conn->real_escape_string($_POST['repuestoID']);
            $sql = "UPDATE repuestos SET nombre='$nombre', descripcion='$descripcion', cantidad='$cantidad', computador_id='$computador_id' WHERE id='$repuestoID'";
        } else {
            $sql = "INSERT INTO repuestos (nombre, descripcion, cantidad, computador_id) VALUES ('$nombre', '$descripcion', '$cantidad', '$computador_id')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Repuesto guardado con éxito.";
        } else {
            echo "Error al guardar repuesto: " . $conn->error;
        }
    } else {
        echo "Completa todos los campos obligatorios.";
    }

    $conn->close();
    header("Location: repuestos.php");
    exit();
}
?>
