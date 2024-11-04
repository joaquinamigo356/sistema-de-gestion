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

    if (isset($_POST['repuestoID'])) {
        $repuestoID = $conn->real_escape_string($_POST['repuestoID']);
        $sql = "DELETE FROM repuestos WHERE id='$repuestoID'";

        if ($conn->query($sql) === TRUE) {
            echo "Repuesto eliminado con éxito.";
        } else {
            echo "Error al eliminar repuesto: " . $conn->error;
        }
    } else {
        echo "ID de repuesto no proporcionado.";
    }

    $conn->close();
    header("Location: repuestos.php");
    exit();
}
?>
