<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../Cesta/sa/vaciarCestaSA.php';

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userid'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'Usuario no autenticado']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Simular procesamiento de pago
$exito = rand(0, 1); // 50% de éxito para prueba

if ($exito) {
    // Vaciar cesta
    $vaciarCestaSA = new vaciarCestaSA();
    $vaciarCestaSA->vaciarCesta($_SESSION['userid']);
    
    echo json_encode([
        'exito' => true,
        'mensaje' => 'Pago procesado correctamente',
        'pedidoId' => uniqid()
    ]);
} else {
    echo json_encode([
        'exito' => false,
        'mensaje' => 'El pago fue rechazado por el banco'
    ]);
}