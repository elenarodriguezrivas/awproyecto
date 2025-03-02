<?php
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioSA {
    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function registrarUsuario(Usuario $usuario): bool {
        if ($this->usuarioDAO->existeUsuario($usuario->getUserid())) {
            return false; // Usuario ya existe
        }
        return $this->usuarioDAO->agregarUsuario($usuario);
    }

    public function verificarCredenciales(string $userid, string $contrasena): bool {
        $usuario = $this->usuarioDAO->obtenerUsuario($userid);
        return $usuario && password_verify($contrasena, $usuario->getContrasena());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena']; // Se hashea en Usuario.php
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);
    $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);

    if (!$userid || !$contrasena || !$email || !$nombre || !$apellidos || !$edad || !$rol) {
        echo "Error: Datos inválidos.";
        exit;
    }

    $usuario = new Usuario($userid, $contrasena, $email, $nombre, $apellidos, $edad, $rol);
    $usuarioSA = new UsuarioSA();

    if ($usuarioSA->registrarUsuario($usuario)) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "El usuario ya existe.";
    }
}
?>
