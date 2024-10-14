<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Verificar si se ha enviado el ID del usuario
    if (isset($_POST['id'])) {
        $id = $conn->real_escape_string($_POST['id']);

        // Consultar el usuario en la base de datos por su ID
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $result = $conn->query($sql);

        // Verificar si se encontró el usuario
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            echo "Usuario no encontrado.";
            exit();
        }
    } else {
        echo "Solicitud inválida.";
        exit();
    }
} else {
    echo "Método de solicitud no permitido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="actualizar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($user['correo']); ?>" required>
        
        <label for="perfil">Perfil:</label>
        <select id="perfil" name="perfil">
            <option value="admin" <?php if ($user['perfil'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="tecnico" <?php if ($user['perfil'] == 'tecnico') echo 'selected'; ?>>Técnico</option>
            <option value="usuario" <?php if ($user['perfil'] == 'usuario') echo 'selected'; ?>>Usuario</option>
        </select>
        
        <button type="submit">Actualizar usuario</button>
    </form>
</body>
</html>
