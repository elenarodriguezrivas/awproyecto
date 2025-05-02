<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Cestas/sa/vaciarCestaSA.php';

session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado.'
    ]);
    exit;
}

$userId = $_SESSION['userid'];

$vaciarCestaSA = new vaciarCestaSA();
$resultado = $vaciarCestaSA->vaciarCesta($userId);

if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'La cesta se ha vaciado correctamente.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo vaciar la cesta.'
    ]);
}