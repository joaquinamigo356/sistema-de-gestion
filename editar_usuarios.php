<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $conexion = new mysqli("localhost", "root", "", "gestion_usuarios");

    if ($conexion->connect_error) {
        die("La conexión falló: " . $conexion->connect_error);
    }

   
    if (isset($_POST['userID']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['perfil'])) {
        
     
        $userID = $conexion->real_escape_string($_POST['userID']);
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $apellido = $conexion->real_escape_string($_POST['apellido']);
        $correo = $conexion->real_escape_string($_POST['correo']);
        $perfil = $conexion->real_escape_string($_POST['perfil']);

       
        $query = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          
            $query = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, perfil = ? WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $perfil, $userID);

            if ($stmt->execute()) {
                echo "Usuario actualizado correctamente.";
            } else {
                echo "Error al actualizar el usuario: " . $stmt->error;
            }
        } else {
            echo "El usuario con ID $userID no existe.";
        }

     
        $stmt->close();
    } else {
        echo "Por favor, completa todos los campos del formulario.";
    }

  
    $conexion->close();
} else {
    echo "Solicitud inválida.";
}
?>

?>
