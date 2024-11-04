<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_usuarios";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mantenimientos = [];


$sql = "SELECT * FROM mantenimiento";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mantenimientos[] = $row;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar']) && isset($_POST['mantenimientoID'])) {
    $mantenimientoID = $_POST['mantenimientoID'];
    $sql = "SELECT * FROM mantenimiento WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mantenimientoID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mantenimiento_editar = $result->fetch_assoc();
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mantenimiento</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="computadores.php">Computadores</a></li>
                <li><a href="software.php">Software</a></li>
                <li><a href="mantenimiento.php" class="active">Mantenimiento</a></li>
                <li><a href="repuestos.php">Repuestos</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Registro de Mantenimiento</h1>
        <p>Aquí puedes registrar y hacer seguimiento de los mantenimientos realizados.</p>

     
     <form action="guardar_mantenimiento.php" method="POST">
            <input type="hidden" name="mantenimientoID" id="mantenimientoID" value="<?php echo $mantenimiento_editar['id'] ?? ''; ?>">
            
            <label for="computador">Computador:</label>
            <input type="text" id="computador" name="computador" value="<?php echo $mantenimiento_editar['computador_id'] ?? ''; ?>" required>

            <label for="dueno">Dueño del Computador:</label>
            <input type="text" id="dueno" name="dueno" value="<?php echo $mantenimiento_editar['dueno'] ?? ''; ?>" required>

            <label for="fecha">Fecha de Mantenimiento:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $mantenimiento_editar['fecha'] ?? ''; ?>" required>

            <label for="tecnico">Técnico Responsable:</label>
            <input type="text" id="tecnico" name="tecnico" value="<?php echo $mantenimiento_editar['tecnico'] ?? ''; ?>" required>

            <label for="repuestos">Repuestos Utilizados:</label>
            <input type="text" id="repuestos" name="repuestos" value="<?php echo $mantenimiento_editar['repuestos'] ?? ''; ?>">

            <label for="descripcion">Descripción del Mantenimiento:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $mantenimiento_editar['descripcion'] ?? ''; ?></textarea>

            <label for="userID">Id_usuario:</label>
            <input type="text" id="userID" name="userID" value="<?php echo $mantenimiento_editar['id_usuario'] ?? ''; ?>" required>

            <button type="submit">Guardar Mantenimiento</button>
            </form>

       
        <h2>Mantenimientos Realizados</h2>
        <table>
            <thead>
                <tr>
                    <th>Computador</th>
                    <th>Dueño</th>
                    <th>Fecha</th>
                    <th>Técnico</th>
                    <th>Repuestos</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mantenimientos as $mantenimiento): ?>
                    <tr>
                        <td><?php echo $mantenimiento['computador_id']; ?></td>
                        <td><?php echo $mantenimiento['dueno']; ?></td>
                        <td><?php echo $mantenimiento['fecha']; ?></td>
                        <td><?php echo $mantenimiento['tecnico']; ?></td>
                        <td><?php echo $mantenimiento['repuestos']; ?></td>
                        <td><?php echo $mantenimiento['descripcion']; ?></td>
                        <td>
                       
                        <form action="mantenimiento.php" method="POST" style="display:inline;">
                                <input type="hidden" name="mantenimientoID" value="<?php echo $mantenimiento['id']; ?>">
                                <input type="hidden" name="editar" value="1">
                                <button type="submit">Editar</button>
                                </form>
                          
                            <form action="eliminar_mantenimiento.php" method="POST" style="display:inline;">
                                <input type="hidden" name="mantenimientoID" value="<?php echo $mantenimiento['id']; ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este mantenimiento?');">Eliminar</button>
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

        
    
