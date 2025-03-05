<?php
require_once __DIR__ . '/../Usuarios/sa/listarProductosSA.php';
session_start();

class ListarProductosController {
    private $listarProductoSA;

    public function __construct() {
        $this->listarProductoSA = new ListarProductosSA();
    }

    public function listarProductos() {
        
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

//se usará para las views, trabajamos con jsons
echo json_encode([
    "nombre" => $user->getNombre(),
    "apellidos" => $user->getApellidos(),
    "edad" => $user->getEdad(),
    "correo" => $correoPixelado
]);
?>
