<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_usuarios";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$repuestos = [];
$computadores = [];
$repuesto_editar = null; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar']) && isset($_POST['repuestoID'])) {
    $repuestoID = $_POST['repuestoID'];
    $sql = "SELECT * FROM repuestos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $repuestoID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $repuesto_editar = $result->fetch_assoc();
    }
    $stmt->close();
}

$sql = "SELECT repuestos.*, computadores.nombre AS nombre_computador FROM repuestos LEFT JOIN computadores ON repuestos.computador_id = computadores.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $repuestos[] = $row;
    }
}

$sql = "SELECT id, nombre FROM computadores";
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
    <title>Gestión de Repuestos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="computadores.php">Computadores</a></li>
                <li><a href="software.php">Software</a></li>
                <li><a href="mantenimiento.php">Mantenimiento</a></li>
                <li><a href="repuestos.php" class="active">Repuestos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Gestión de Repuestos</h1>
        <p>Aquí puedes registrar y gestionar los repuestos disponibles en el sistema.</p>

        <form action="guardar_repuesto.php" method="POST">
            <input type="hidden" name="repuestoID" id="repuestoID" value="<?php echo $repuesto_editar['id'] ?? ''; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $repuesto_editar['nombre'] ?? ''; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?php echo $repuesto_editar['descripcion'] ?? ''; ?></textarea>
            <label for="cantidad">Cantidad Disponible:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo $repuesto_editar['cantidad'] ?? '0'; ?>" required>

            <label for="computador">Computador:</label>
            <select id="computador" name="computador">
                <?php foreach ($computadores as $computador): ?>
                    <option value="<?php echo $computador['id']; ?>" <?php if (($repuesto_editar['computador_id'] ?? '') == $computador['id']) echo 'selected'; ?>>
                        <?php echo $computador['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Guardar Repuesto</button>
        </form>

        <h2>Repuestos Disponibles</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Computador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repuestos as $repuesto): ?>
                    <tr>
                        <td><?php echo $repuesto['nombre']; ?></td>
                        <td><?php echo $repuesto['descripcion']; ?></td>
                        <td><?php echo $repuesto['cantidad']; ?></td>
                        <td><?php echo $repuesto['nombre_computador'] ?? 'N/A'; ?></td>
                        <td>
                            <form action="repuestos.php" method="POST" style="display:inline;">
                                <input type="hidden" name="repuestoID" value="<?php echo $repuesto['id']; ?>">
                                <input type="hidden" name="editar" value="1">
                                <button type="submit">Editar</button>
                            </form>

                            <form action="eliminar_repuesto.php" method="POST" style="display:inline;">
                                <input type="hidden" name="repuestoID" value="<?php echo $repuesto['id']; ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este repuesto?');">Eliminar</button>
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
