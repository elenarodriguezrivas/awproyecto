<?php
require_once __DIR__ . '/../Usuarios/sa/perfilSA.php';
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Usuario no autenticado."]);
    exit();
}

$perfilSA = new PerfilSA();
$usuario = $perfilSA->obtenerUsuarioPorId($_SESSION['userid']);

if (!$usuario) {
    echo json_encode(["error" => "Usuario no encontrado."]);
    exit();
}

function pixelarCorreo($correo) {
    $partes = explode("@", $correo);
    $inicio = substr($partes[0], 0, 2) . str_repeat("*", max(0, strlen($partes[0]) - 2));
    return $inicio . "@" . $partes[1];
}

$correoPixelado = pixelarCorreo($usuario->getEmail());

//se usará para las views, trabajamos con jsons
echo json_encode([
    "nombre" => $usuario->getNombre(),
    "apellidos" => $usuario->getApellidos(),
    "edad" => $usuario->getEdad(),
    "correo" => $correoPixelado
]);
?>
