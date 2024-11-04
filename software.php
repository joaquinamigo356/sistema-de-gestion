<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_usuarios";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$softwares = [];
$software_editar = null; 


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar']) && isset($_POST['softwareID'])) {
    $softwareID = $_POST['softwareID'];
    $sql = "SELECT * FROM software WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $softwareID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $software_editar = $result->fetch_assoc();
    }
    $stmt->close();
}


$sql = "SELECT * FROM software";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $softwares[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Software</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="computadores.php">Computadores</a></li>
                <li><a href="software.php" class="active">Software</a></li>
                <li><a href="mantenimiento.php">Mantenimiento</a></li>
                <li><a href="repuestos.php">Repuestos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Gestión de Software</h1>
        <p>Aquí puedes registrar y gestionar el software instalado en los computadores.</p>

      
        <form action="guardar_software.php" method="POST">
            <input type="hidden" name="softwareID" id="softwareID" value="<?php echo $software_editar['id'] ?? ''; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $software_editar['nombre'] ?? ''; ?>" required>

            <label for="version">Versión:</label><input type="text" id="version" name="version" value="<?php echo $software_editar['version'] ?? ''; ?>">

<label for="licencia">Licencia:</label>
<input type="text" id="licencia" name="licencia" value="<?php echo $software_editar['licencia'] ?? ''; ?>">

<label for="id_usuario">ID del Usuario:</label>
<input type="number" id="id_usuario" name="id_usuario" value="<?php echo $software_editar['id_usuario'] ?? ''; ?>" required>

<button type="submit">Guardar Software</button>
</form>


<h2>Software Instalado en los Computadores</h2>
<table>
<thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Versión</th>
        <th>Licencia</th>
        <th>ID del Usuario</th>
        <th>Acciones</th>
    </tr>
    </thead>
            <tbody>
                <?php foreach ($softwares as $software): ?>
                    <tr>
                        <td><?php echo $software['id']; ?></td>
                        <td><?php echo $software['nombre']; ?></td>
                        <td><?php echo $software['version']; ?></td>
                        <td><?php echo $software['licencia']; ?></td>
                        <td><?php echo $software['id_usuario']; ?></td>
                        <td>
                          
                            <form action="software.php" method="POST" style="display:inline;">
                                <input type="hidden" name="softwareID" value="<?php echo $software['id']; ?>">
                                <input type="hidden" name="editar" value="1">
                                <button type="submit">Editar</button>
                            </form>

                           
                            <form action="eliminar_software.php" method="POST" style="display:inline;">
                                <input type="hidden" name="softwareID" value="<?php echo $software['id']; ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este software?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
    </main>
    <footer>
        <p>&copy; 2024 Gestión de Computadores. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
