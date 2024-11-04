<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_usuarios";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$estadisticas = [];
$estadistica_editar = null; 


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar']) && isset($_POST['estadisticaID'])) {
    $estadisticaID = $_POST['estadisticaID'];
    $sql = "SELECT * FROM estadisticas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $estadisticaID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $estadistica_editar = $result->fetch_assoc();
    }
    $stmt->close();}

    
    $sql = "SELECT * FROM estadisticas";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $estadisticas[] = $row;
        }
    }
    
    $conn->close();
    ?>
    
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estadísticas del Sistema</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="computadores.php">Computadores</a></li>
                    <li><a href="usuarios.php">Usuarios</a></li> <li><a href="software.php">Software</a></li>
                <li><a href="mantenimiento.php">Mantenimiento</a></li>
                <li><a href="estadisticas.php" class="active">Estadísticas</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Estadísticas del Sistema</h1>
        <p>Aquí puedes registrar y visualizar estadísticas del sistema.</p>

        <form action="guardar_estadistica.php" method="POST">
            <input type="hidden" name="estadisticaID" id="estadisticaID" value="<?php echo $estadistica_editar['id'] ?? ''; ?>">

            <label for="tipo_estadistica">Tipo de Estadística:</label>
            <input type="text" id="tipo_estadistica" name="tipo_estadistica" value="<?php echo $estadistica_editar['tipo_estadistica'] ?? ''; ?>" required>

            <label for="valor">stonks:</label>
            <input type="number" id="valor" name="valor" step="any" value="<?php echo $estadistica_editar['valor'] ?? ''; ?>" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $estadistica_editar['fecha'] ?? ''; ?>" required>

            <button type="submit">Guardar Estadística</button>
        </form>
 <h2>Datos Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Estadística</th>
                    <th>stonks</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estadisticas as $estadistica): ?>
                    <tr>
                        <td><?php echo $estadistica['id']; ?></td>
                        <td><?php echo $estadistica['tipo_estadistica']; ?></td>
                        <td><?php echo $estadistica['valor']; ?></td>
                        <td><?php echo $estadistica['fecha']; ?></td>
                        <td>
                            <!-- Botón de editar -->
                            <form action="estadisticas.php" method="POST" style="display:inline;">
                                <input type="hidden" name="estadisticaID" value="<?php echo $estadistica['id']; ?>">
                                <input type="hidden" name="editar" value="1">
                                <button type="submit">Editar</button>
                            </form>

                           
                            <form action="eliminar_estadistica.php" method="POST" style="display:inline;">
                            <input type="hidden" name="estadisticaID" value="<?php echo $estadistica['id']; ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta estadística?');">Eliminar</button>
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
