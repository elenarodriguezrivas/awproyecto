<?php
session_start();
if (isset($_SESSION['userid'])) {
    header("Location: perfil_pantalla.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body>
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

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">⚠️ <?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>
</body>
</html>
