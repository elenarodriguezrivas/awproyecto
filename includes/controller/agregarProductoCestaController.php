<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Cestas/sa/agregarProductoCestaSA.php';

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

$cestaSA = new agregarProductoCestaSA();
$resultado = $cestaSA->agregarProductoCesta($userId, $productoId);

if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Producto agregado a la cesta correctamente.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo agregar el producto de la cesta.'
    ]);
}