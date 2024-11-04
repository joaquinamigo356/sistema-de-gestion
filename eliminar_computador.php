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

    
    if (isset($_POST['computadorID'])) {
        $computadorID = $conn->real_escape_string($_POST['computadorID']);

        
        $sql = "DELETE FROM computadores WHERE id = '$computadorID'";

        if ($conn->query($sql) === TRUE) {
            echo "Computador eliminado exitosamente.";
        } else {
            echo "Error al eliminar el computador: " . $conn->error;
        }
    } else {
        echo "ID de computador no proporcionado.";
    }

    
    $conn->close();

    
    header("Location: computadores.php");
    exit();
} else {
    echo "Solicitud inválida.";
}
?>
