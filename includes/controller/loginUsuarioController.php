<?php
require_once __DIR__ . '/../Usuarios/sa/loginSA.php';

$usuarioSA = new UsuarioSA();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = htmlspecialchars($_POST['userid'], ENT_QUOTES, 'UTF-8');
    $contrasena = $_POST['contrasena'];

    if (!$userid || !$contrasena) {
        echo "Error: Datos inválidos.";
        exit;
    }

    if ($usuarioSA->loginUsuario($userid, $contrasena)) {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['userid'] = $userid;
        echo "Login exitoso.";
    } else {
        echo "Error: Usuario o contraseña incorrectos.";
    }
}
?>