<?php
session_start();
require_once __DIR__ . '/../Usuarios/sa/registroSA.php';
require_once __DIR__ . '/../Usuarios/model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrar y validar entrada del usuario
    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $contrasena = $_POST['contrasena']; // No sanitizar aquí, se hashea en Usuario.php
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);

    // Verificar si los datos son válidos
    if (!$userid) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: User ID inválido.";
        exit;
    }
    if (!$contrasena) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Contraseña inválida.";
        exit;
    }
    if (!$email) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Email inválido.";
        exit;
    }
    if (!$nombre) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Nombre inválido.";
        exit;
    }
    if (!$apellidos) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Apellidos inválidos.";
        exit;
    }
    if (!$edad) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Edad inválida.";
        exit;
    }

    // Asignar rol por defecto
    $rol = 'usuario';

    // Crear el objeto usuario
    $usuario = new Usuario($userid, $contrasena, $email, $nombre, $apellidos, $edad, $rol);
    
    // Instanciar servicio de aplicación
    $usuarioSA = new UsuarioSA();

    // Intentar registrar al usuario
    try {
        if ($usuarioSA->registrarUsuario($usuario)) {
            http_response_code(201); // Código 201 - Created
            echo "Usuario registrado con éxito.";
        } else {
            http_response_code(409); // Código 409 - Conflict (usuario ya existe)
            echo "El usuario ya existe.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Código 500 - Internal Server Error
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
    exit;
}
?>