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

    if (isset($_POST['estadisticaID'])) {
        $estadisticaID = $conn->real_escape_string($_POST['estadisticaID']);
        $sql = "DELETE FROM estadisticas WHERE id='$estadisticaID'";

        if ($conn->query($sql) === TRUE) {
            echo "Estadística eliminada con éxito.";
        } else {
            echo "Error al eliminar estadística: " . $conn->error;
        }
    } else {
        echo "ID de estadística no proporcionado.";
    }

    $conn->close();
    header("Location: estadisticas.php");
    exit();
}
?>


