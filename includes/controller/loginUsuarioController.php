<?php
require_once __DIR__ . '/../Usuarios/sa/loginSA.php';

class LoginUsuarioController {
    private UsuarioSA $usuarioSA;

    public function __construct() {
        $this->usuarioSA = new UsuarioSA();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
            $contrasena = $_POST['contrasena'];

            if (!$userid || !$contrasena) {
                echo "Error: Datos inválidos.";
                return;
            }

            if ($this->usuarioSA->loginUsuario($userid, $contrasena)) {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['userid'] = $userid;
                echo "Login exitoso.";
            } else {
                echo "Error: Usuario o contraseña incorrectos.";
            }
        }
    }
}

// Crear una instancia del controlador y llamar al método de login
$controller = new LoginUsuarioController();
$controller->login();
?>