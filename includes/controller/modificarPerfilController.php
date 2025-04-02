<?php
session_start();
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuarios/dao/UsuarioDAO.php';
require_once __DIR__.'/../Usuarios/model/Usuario.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    http_response_code(401);
    echo "No se ha iniciado sesión.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['userid'];
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);
    $contrasena = $_POST['contrasena'];

    // Validaciones básicas en el servidor
    if (!$nombre || empty($nombre)) {
        http_response_code(400);
        echo "El nombre no puede estar vacío.";
        exit;
    }
    
    if (!$apellidos || empty($apellidos)) {
        http_response_code(400);
        echo "Los apellidos no pueden estar vacíos.";
        exit;
    }
    
    if (!$email) {
        http_response_code(400);
        echo "El correo electrónico no es válido.";
        exit;
    }
    
    if (!$edad || $edad < 1) {
        http_response_code(400);
        echo "La edad debe ser un número mayor a 0.";
        exit;
    }

    // Obtener usuario actual
    $usuarioDAO = new UsuarioDAO();
    $usuarioActual = $usuarioDAO->obtenerUsuario($userid);
    
    if (!$usuarioActual) {
        http_response_code(404);
        echo "Usuario no encontrado.";
        exit;
    }

    // Usar la contraseña actual si no se proporciona una nueva
    $nuevaContrasena = $usuarioActual->getContrasena();
    
    // Si se proporciona una nueva contraseña, validar y actualizar
    if (!empty($contrasena)) {
        if (empty($_POST['confirmarContrasena']) || $contrasena !== $_POST['confirmarContrasena']) {
            http_response_code(400);
            echo "Las contraseñas no coinciden.";
            exit;
        }
        
        // Hashear la nueva contraseña
        $nuevaContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    }
    
    // Crear objeto usuario con los datos actualizados
    $usuarioActualizado = new Usuario(
        $userid,
        $nuevaContrasena,
        $email,
        $nombre,
        $apellidos,
        $edad,
        $usuarioActual->getRol()
    );
    
    // Agregar método actualizarUsuario al UsuarioDAO si no existe
    if ($usuarioDAO->actualizarUsuario($usuarioActualizado)) {
        // Actualizar datos de la sesión
        $_SESSION['nombre'] = $nombre;
        
        http_response_code(200);
        echo "Perfil actualizado correctamente.";
    } else {
        http_response_code(500);
        echo "Error al actualizar el perfil.";
    }
    
    exit;
}
?>