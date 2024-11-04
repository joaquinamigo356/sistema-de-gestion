<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'gestion_usuarios';

    
    $conn = new mysqli($server, $user, $pass, $db);

   
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    
    if (isset($_POST['userID']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['perfil'])) {
        $id = $conn->real_escape_string($_POST['userID']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $correo = $conn->real_escape_string($_POST['correo']);
        $perfil = $conn->real_escape_string($_POST['perfil']);

       
        $checkSql = "SELECT id FROM usuarios WHERE id = '$id'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
           
            $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', correo='$correo', perfil='$perfil' WHERE id='$id'";
            $mensaje = "Usuario actualizado exitosamente.";
        } else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (id, nombre, apellido, correo, password, perfil) VALUES ('$id', '$nombre', '$apellido', '$correo','$password', '$perfil')";
            $mensaje = "Usuario registrado exitosamente.";
        }

        
        if ($conn->query($sql) === TRUE) {
            echo $mensaje;
        } else {
            echo "Error al guardar usuario: " . $conn->error;
        }
    } else {
        echo "Por favor, completa todos los campos del formulario.";
    }

    
    $conn->close();

  
    header("Location: usuarios.php");
    exit();
} else {
    echo "Solicitud inválida.";
}
?>
