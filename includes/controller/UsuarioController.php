<?php
session_start();
require_once __DIR__ . '/../sa/UsuarioSA.php';
require_once __DIR__ . '/../model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrar y validar entrada del usuario
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena']; // No sanitizar aquí, se hashea en Usuario.php
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);
    $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_STRING);

    // Verificar si los datos son válidos
    if (!$userid || !$contrasena || !$email || !$nombre || !$apellidos || !$edad || !$rol) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Datos inválidos.";
        exit;
    }

    // Crear el objeto usuario
    $usuario = new Usuario($userid, $contrasena, $email, $nombre, $apellidos, $edad, $rol);
    
    // Instanciar servicio de aplicación
    $usuarioSA = new UsuarioSA();

    // Intentar registrar al usuario
    if ($usuarioSA->registrarUsuario($usuario)) {
        http_response_code(201); // Código 201 - Created
        echo "Usuario registrado con éxito.";
    } else {
        http_response_code(409); // Código 409 - Conflict (usuario ya existe)
        echo "El usuario ya existe.";
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'login') {
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena']; // Se valida en UsuarioSA.php

    if (!$userid || !$contrasena) {
        header("Location: ../../view/login_pantalla.php?error=Datos inválidos.");
        exit;
    }

    if ($usuarioSA->verificarCredenciales($userid, $contrasena)) {
        $_SESSION['userid'] = $userid;
        header("Location: ../../view/perfil_pantalla.php");
        exit;
    } else {
        header("Location: ../../view/login_pantalla.php?error=Usuario o contraseña incorrectos.");
        exit;
    }
}
?>
?>
