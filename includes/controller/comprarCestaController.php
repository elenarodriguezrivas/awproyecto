<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Cestas/sa/vaciarCestaSA.php';
require_once __DIR__ . '/../Ventas/sa/registrarVentaSA.php';

session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado.'
    ]);
    exit;
}

$userId = $_SESSION['userid'];

$cestaSA = new vaciarCestaSA();
$productoSA = new registrarVentaSA();

// Obtener los productos de la cesta
$cesta = $cestaSA->obtenerCesta($userId);

if (!$cesta || empty($cesta->getProductosCesta())) {
    echo json_encode([
        'success' => false,
        'message' => 'La cesta está vacía.'
    ]);
    exit;
}

$productos = $cesta->getProductosCesta();
$errores = [];

// Procesar la compra de cada producto
foreach ($productos as $producto) {
    $resultado = $productoSA->registrarVenta($userId, $producto->getId());
    if (!$resultado) {
        $errores[] = "No se pudo comprar el producto con ID: " . $producto->getId();
    }
}

// Vaciar la cesta después de la compra
if (empty($errores)) {
    $cestaSA->vaciarCesta($userId);
    echo json_encode([
        'success' => true,
        'message' => 'Todos los productos se compraron correctamente.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Algunos productos no se pudieron comprar.',
        'errores' => $errores
    ]);
}