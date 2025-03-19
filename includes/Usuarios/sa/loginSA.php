<?php
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioSA {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function loginUsuario(string $userid, string $contrasena): bool {
        if ($this->usuarioDAO->existeUsuario($userid)) {
            return $this->usuarioDAO->comprobarContrasena($userid, $contrasena);
        }
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena'];

    if (!$userid || !$contrasena) {
        echo "Error: Datos inválidos.";
        exit;
    }

    $usuarioSA = new UsuarioSA();
    if ($usuarioSA->loginUsuario($userid, $contrasena)) {
        echo "Login exitoso.";
    }
}
?>