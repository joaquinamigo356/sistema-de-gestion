<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_usuarios";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$loginError = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];

            header("Location: index.php");
            exit();
        } else {
            $loginError = "Contraseña incorrecta.";
        }
    } else {
        $loginError = "El usuario no existe.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Computadores - Inicio de Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div id="header-inner">
            <div id="logo">
            <img src="img/pics/Picture1.png" alt="Logo">
            </div>
            
            <nav>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Computadores</a></li>
                    <li><a href="#">Usuarios</a></li>
                    <li><a href="#">Software</a></li>
                    <li><a href="#">Mantenimiento</a></li>
                    <li><a href="#">Estadísticas</a></li>
                    <li><a href="#">Repuestos</a></li>
                </ul>
            </nav>
        </div>

        <div class="login-container">
            <h2>Sistema de Gestión - Iniciar Sesión</h2>
            <?php if ($loginError): ?>
                <p style="color:red;"><?php echo $loginError; ?></p>
            <?php endif; ?>
            <form id="loginForm" action="inicio-sesion.php" method="POST">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
        <div class="register-container">
            <h2>Registro de Usuario</h2>
            <form id="registerForm" action="registrar_usuario.php" method="POST">
                <label for="newUsername">Usuario:</label>
                <input type="text" id="newUsername" name="newUsername" placeholder="Ingrese su nombre de usuario" required>
                
                <label for="newEmail">Correo:</label>
                <input type="email" id="newEmail" name="newEmail" placeholder="Ingrese su correo" required>
                
                <label for="newPassword">Contraseña:</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Ingrese su contraseña" required>
                
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </header>
</body>
</html>
