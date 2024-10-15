<?php
// Conexión a la base de datos
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'gestion_usuarios';

$conn = new mysqli($server, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha enviado un ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Obtener los datos del usuario
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "ID no especificado.";
    exit;
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
    <header>
        <nav>
            <ul>
                <li><a href="usuarios.html">Usuarios</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Editar Usuario</h1>
        <form action="actualizar_usuarios.php" method="post">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $user['nombre']; ?>" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $user['apellido']; ?>" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $user['correo']; ?>" required>

            <label for="perfil">Perfil:</label>
            <select id="perfil" name="perfil">
                <option value="admin" <?php echo ($user['perfil'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="tecnico" <?php echo ($user['perfil'] == 'tecnico') ? 'selected' : ''; ?>>Técnico</option>
                <option value="usuario" <?php echo ($user['perfil'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
            </select>

            <button type="submit">Actualizar Usuario</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Gestión de Computadores. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
