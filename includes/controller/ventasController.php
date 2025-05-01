<?php
session_start();
require_once __DIR__ . '/../Ventas/sa/ventasSA.php';

if (!isset($_SESSION['userid'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'No se ha iniciado sesión.']);
    exit;
}

$action = $_GET['action'] ?? null;

if (!$action) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'No se especificó ninguna acción.']);
    exit;
}

$ventasSA = new VentasSA();

try {
    switch ($action) {
        case 'registrarVenta':
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (empty($data['cesta']) || !is_array($data['cesta'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Datos de la cesta inválidos.']);
                exit;
            }

            $userid = $_SESSION['userid'];
            $resultado = $ventasSA->registrarVenta($userid, $data['cesta']);

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Venta registrada con éxito.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo registrar la venta.']);
            }
            break;

        case 'obtenerProductosComprados':

            $userid = $_SESSION['userid'];
            $compras = $ventasSA->obtenerComprasPorUsuario($userid);
            error_log("Compras obtenidas: " . print_r($compras, true));
            echo json_encode(['success' => true, 'compras' => $compras]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Acción no válida.']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno: ' . $e->getMessage()]);
}
?>