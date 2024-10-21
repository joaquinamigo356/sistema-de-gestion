<?php
if ($_SERVER['REQUEST_METHOD'] ??''=== 'POST') {
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';


    $conn = new mysqli($server, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

  
    if (isset($_POST['id'])) {
        $id = $conn->real_escape_string($_POST['id']);

    
        $sql = "SELECT * FROM usuarios WHERE id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            
            if (isset($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['perfil'])) {
                $nombre = $conn->real_escape_string($_POST['nombre']);
                $apellido = $conn->real_escape_string($_POST['apellido']);
                $correo = $conn->real_escape_string($_POST['correo']);
                $perfil = $conn->real_escape_string($_POST['perfil']);

                
                $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', correo='$correo', perfil='$perfil' WHERE id='$id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Usuario actualizado exitosamente.";
                } else {
                    echo "Error al actualizar usuario: " . $conn->error;
                }
            } else {
                echo "Por favor, complete todos los campos requeridos.";
            }
        } else {
            echo "No se encontró un usuario con el ID proporcionado.";
        }
    } else {
        echo "ID de usuario no proporcionado.";
    }

    $conn->close();
}
?>
  
