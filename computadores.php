<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$computador = null;
$computadores = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['computadorID']) && isset($_POST['editar'])) {
    $computadorID = $_POST['computadorID'];
    $sql = "SELECT * FROM computadores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $computadorID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $computador = $result->fetch_assoc();
    } else {
        echo "Computador no encontrado";
    }
    $stmt->close();
}


$sql = "SELECT * FROM computadores";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $computadores[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Computadores</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="computadores.php" class="active">Computadores</a></li>
                <li><a href="software.php">Software</a></li>
                <li><a href="mantenimiento.php">Mantenimiento</a></li>
                <li><a href="repuestos.php">Repuestos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Gestión de Computadores</h1>
        <p>Aquí puedes registrar y gestionar los computadores en el sistema.</p>
        
        
        <form action="guardar_computador.php" method="POST">
            <input type="hidden" name="computadorID" value="<?php echo $computador['id'] ?? ''; ?>">

            <label for="usuario_computador">Usuario del computador:</label>
            <input type="text" id="usuario_computador" name="usuario_computador" value="<?php echo $computador['usuario_computador'] ?? ''; ?>" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $computador['nombre'] ?? ''; ?>" required>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo $computador['modelo'] ?? ''; ?>">

            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" value="<?php echo $computador['marca'] ?? ''; ?>">

            <label for="numero_serie">Número de Serie:</label>
            <input type="text" id="numero_serie" name="numero_serie" value="<?php echo $computador['numero_serie'] ?? ''; ?>" required>

            <button type="submit">Guardar Computador</button>
        </form>

        
        <h2>Computadores Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Usuario del computador</th>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Número de Serie</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($computadores as $computador): ?>
                    <tr>
                        <td><?php echo $computador['usuario_computador']; ?></td>
                        <td><?php echo $computador['nombre']; ?></td>
                        <td><?php echo $computador['modelo']; ?></td>
                        <td><?php echo $computador['marca']; ?></td>
                        <td><?php echo $computador['numero_serie']; ?></td>
                        <td>
                            
                            <form action="computadores.php" method="POST" style="display:inline;">
                                <input type="hidden" name="computadorID" value="<?php echo $computador['id']; ?>">
                                <input type="hidden" name="editar" value="1">
                                <button type="submit">Editar</button>
                            </form>
                            
                            
                            <form action="eliminar_computador.php" method="POST" style="display:inline;">
                                <input type="hidden" name="computadorID" value="<?php echo $computador['id']; ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este computador?');">Borrar</button>
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
