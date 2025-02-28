<?php
require_once './includes/Usuarios/sa/registrarUsuario_SA.php';
require_once './includes/Usuarios/model/Usuario.php';

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