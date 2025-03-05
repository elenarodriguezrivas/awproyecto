<?php
session_start();
require_once __DIR__ . '/../Usuarios/sa/registroSA.php';
require_once __DIR__ . '/../Usuarios/model/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrar y validar entrada del usuario
    $userid = htmlspecialchars($_POST['userid'], ENT_QUOTES, 'UTF-8');
    $contrasena = $_POST['contrasena']; // No sanitizar aquí, se hashea en Usuario.php
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
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
    $usuarioSA = new RegistroSA();

    // Intentar registrar al usuario
    try {
        if ($usuarioSA->registrarUsuario($usuario)) {
            // Iniciar sesión
            $_SESSION['login'] = true;
            $_SESSION['userid'] = $usuario->getUserid();
            $_SESSION['nombre'] = $usuario->getNombre();
            $_SESSION['rol'] = $usuario->getRol();

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