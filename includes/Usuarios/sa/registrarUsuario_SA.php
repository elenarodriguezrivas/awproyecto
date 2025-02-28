<?php
require_once './includes/Usuarios/dao/UsuarioDAO.php';
require_once './includes/Usuarios/model/Usuario.php';

class RegistrarUsuarioSA {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function registrarUsuario(Usuario $usuario) {
        if ($this->usuarioDAO->existeUsuario($usuario->getUserid())) {
            return false; // Usuario ya existe
        } else {
            return $this->usuarioDAO->agregarUsuario($usuario);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];
    $contrasena = $_POST['contrasena'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $rol = $_POST['rol'];

    $usuario = new Usuario($userid, $contrasena, $email, $nombre, $apellidos, $edad, $rol);
    $registrarUsuarioSA = new RegistrarUsuarioSA();

    if ($registrarUsuarioSA->registrarUsuario($usuario)) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "El usuario ya existe.";
    }
}
?>