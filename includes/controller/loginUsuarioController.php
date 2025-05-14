<?php
require_once __DIR__ . '/../Usuarios/sa/loginSA.php';
require_once __DIR__ . '/../Usuarios/sa/perfilSA.php'; // Incluir PerfilSA

$usuarioSA = new UsuarioSA();
$perfilSA = new PerfilSA(); // Instancia de PerfilSA

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = htmlspecialchars($_POST['userid'], ENT_QUOTES, 'UTF-8');
    $contrasena = $_POST['contrasena'];

    if (!$userid || !$contrasena) {
        echo "Error: Datos inválidos.";
        exit;
    }

    // Verificar las credenciales del usuario
    $loginExitoso = $usuarioSA->loginUsuario($userid, $contrasena);

    if ($loginExitoso) {
        session_start();
        $_SESSION['login'] = true;
        $_SESSION['userid'] = $userid;

        // Obtener los datos del usuario desde PerfilSA
        $usuario = $perfilSA->obtenerUsuarioPorId($userid);

        // Verificar si el usuario es administrador
        if ($usuario && $usuario['rol'] === 'admin') { // Suponiendo que el rol de administrador es 1
            $_SESSION['rol'] = 'admin';
        }

        echo "Login exitoso.";
    } else {
        echo "Error: Usuario o contraseña incorrectos.";
    }
}
?>