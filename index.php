<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no ha iniciado sesión, redirigir al formulario de login
    header("Location: inicio-sesion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php" class="active">Inicio</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
        <p>Esta es la página de inicio. Puedes acceder a otras secciones del sistema.</p>
        
        <section>
        <h2>Acceso rápido</h2>
            <p><a href="dashboard.php">Ir al panel de control</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Gestión de Computadores. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
