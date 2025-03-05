<?php
require_once __DIR__ . '/../Usuarios/sa/perfilSA.php';
session_start();

class ObtenerPerfilController {
    private $perfilSA;

    public function __construct() {
        $this->perfilSA = new PerfilSA();
    }

    public function mostrarPerfil($idUsuario) {
        $usuario = $this->perfilSA->obtenerUsuarioPorId($idUsuario);
        if ($usuario) {
            return $usuario; // Devolver datos para la vista
        } else {
            return null;
        }
    }
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Instanciar el controlador y obtener el perfil
$controller = new ObtenerPerfilController();
$user = $controller->mostrarPerfil($_SESSION['userid']);

if (!$user) {
    die("Error: Usuario no encontrado.");
}

// Pixelar correo
function pixelarCorreo($correo) {
    $partes = explode("@", $correo);
    $inicio = substr($partes[0], 0, 2) . str_repeat("*", max(0, strlen($partes[0]) - 2));
    return $inicio . "@" . $partes[1];
}

$correoPixelado = pixelarCorreo($user['email']);
$imagenPerfil = !empty($user['idImagen']) ? "img/" . $user['idImagen'] : "img/default.png";
?>
