<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Cestas/sa/borrarProductoCestaSA.php';

session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado.'
    ]);
    exit;
}

$userId = $_SESSION['userid'];

if (!isset($_POST['productoId'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID del producto no proporcionado.'
    ]);
    exit;
}

$productoId = intval($_POST['productoId']);

$cestaSA = new borrarProductoCestaSA();
$resultado = $cestaSA->borrarProductoCesta($userId, $productoId);

if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Producto eliminado de la cesta correctamente.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo eliminar el producto de la cesta.'
    ]);
}