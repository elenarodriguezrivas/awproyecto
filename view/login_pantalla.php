<?php
if (isset($_SESSION['userid'])) {
    header("Location: perfil_pantalla.php");
    exit;
}

// Definir el contenido principal que se mostrará en la plantilla
$contenidoPrincipal = <<<EOS
    <h2>Iniciar Sesión</h2>
    <form action="../includes/controller/UsuarioController.php" method="POST">
        <label for="userid">Usuario:</label>
        <input type="text" id="userid" name="userid" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>

        <input type="hidden" name="action" value="login">
        <button type="submit">Iniciar Sesión</button>
    </form>

    <p>¿No tienes cuenta? <a href="register_pantalla.php">Regístrate aquí</a></p>

    EOS;

// Si hay un error, mostrarlo en la pantalla
if (isset($_GET['error'])) {
    $contenidoPrincipal .= "<p style='color:red;'>⚠️ " . htmlspecialchars($_GET['error']) . "</p>";
}

// Incluir la plantilla para que se muestre correctamente
require_once __DIR__ . '/../comun/plantilla.php';
?>
