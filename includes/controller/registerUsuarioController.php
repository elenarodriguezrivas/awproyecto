<?php
session_start();
require_once __DIR__ . '/../Usuarios/sa/registroSA.php';
require_once __DIR__ . '/../Usuarios/model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = htmlspecialchars($_POST['userid'], ENT_QUOTES, 'UTF-8');
    $contrasena = $_POST['contrasena']; // No sanitizar aquí, se hashea en Usuario.php
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);

    if (!$userid) {
        http_response_code(400); 
        echo "Error: User ID inválido.";
        exit;
    }
    if (!$contrasena) {
        http_response_code(400); 
        echo "Error: Contraseña inválida.";
        exit;
    }
    if (!$email) {
        http_response_code(400); 
        echo "Error: Email inválido.";
        exit;
    }
    if (!$nombre) {
        http_response_code(400); 
        echo "Error: Nombre inválido.";
        exit;
    }
    if (!$apellidos) {
        http_response_code(400); 
        echo "Error: Apellidos inválidos.";
        exit;
    }
    if (!$edad) {
        http_response_code(400); 
        echo "Error: Edad inválida.";
        exit;
    }

    // Asignar rol por defecto
    $rol = 'usuario';

    $usuario = new Usuario($userid, $contrasena, $email, $nombre, $apellidos, $edad, $rol);
    
    $usuarioSA = new RegistroSA();

    try {
        if ($usuarioSA->registrarUsuario($usuario)) {
            $_SESSION['login'] = true;
            $_SESSION['userid'] = $usuario->getUserid();
            $_SESSION['nombre'] = $usuario->getNombre();
            $_SESSION['rol'] = $usuario->getRol();

            http_response_code(201);
            echo "Usuario registrado con éxito.";
        } else {
            http_response_code(409); 
            echo "El usuario ya existe.";
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
    exit;
}
?>