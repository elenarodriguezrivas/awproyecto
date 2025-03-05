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
            return $usuario;
        } else {
            return null;
        }
    }
}

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Usuario no autenticado."]);
    exit();
}

$controller = new ObtenerPerfilController();
$user = $controller->mostrarPerfil($_SESSION['userid']);

if (!$user) {
    echo json_encode(["error" => "Usuario no encontrado."]);
    exit();
}

function pixelarCorreo($correo) {
    $partes = explode("@", $correo);
    $inicio = substr($partes[0], 0, 2) . str_repeat("*", max(0, strlen($partes[0]) - 2));
    return $inicio . "@" . $partes[1];
}

$correoPixelado = pixelarCorreo($user->getEmail());

echo json_encode([
    "nombre" => $user->getNombre(),
    "apellidos" => $user->getApellidos(),
    "edad" => $user->getEdad(),
    "correo" => $correoPixelado
]);
?>
