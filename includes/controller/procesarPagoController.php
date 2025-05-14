<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php';
require_once __DIR__.'/../Cestas/sa/vaciarCestaSA.php';
require_once __DIR__.'/../Cestas/sa/obtenerCestaSA.php';

session_start();

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

function procesarPago($userId) {
    if (!$userId) {
        return [
            'tipo' => 'error',
            'mensaje' => 'No pudimos identificar tu sesión. Si crees que esto es un error, por favor contacta con atención al cliente.',
        ];
    }

    try {
        $cestaSA = new obtenerCestaSA();
        $cesta = $cestaSA->obtenerCesta($userId);

        if (!$cesta || empty($cesta->getProductosCesta())) {
            return [
                'tipo' => 'error',
                'mensaje' => 'No hay productos en tu cesta para procesar el pago.',
            ];
        }

        $productos = $cesta->getProductosCesta();
        $db = DB::getInstance();
        $db->getBD()->beginTransaction();

        // Marcar los productos como vendidos
        foreach ($productos as $producto) {
            $productoId = $producto->getId();
            $db->query("UPDATE Productos SET estado = 'vendido' WHERE id = ?", [$productoId]);

            $idVendedor = $producto->getIdVendedor();
            $existeVenta = $db->query(
                "SELECT 1 FROM Ventas WHERE producto_id = ? AND vendedor_id = ? AND comprador_id = ?",
                [$productoId, $idVendedor, $userId]
            )->rowCount();

            if ($existeVenta === 0) {
                $db->query(
                    "INSERT INTO Ventas (producto_id, vendedor_id, comprador_id) VALUES (?, ?, ?)",
                    [$productoId, $idVendedor, $userId]
                );
            }
        }

        // Vaciar la cesta del usuario
        $vaciarCestaSA = new vaciarCestaSA();
        $vaciarCestaSA->vaciarCesta($userId);

        $db->getBD()->commit();
        return [
            'tipo' => 'success',
            'mensaje' => 'Tu pedido ha sido procesado correctamente y recibirás un correo electrónico con los detalles.',
        ];
    } catch (Exception $e) {
        if (isset($db) && $db->getBD()->inTransaction()) {
            $db->getBD()->rollBack();
        }
        error_log("Error al procesar pago: " . $e->getMessage());
        return [
            'tipo' => 'error',
            'mensaje' => 'Hemos registrado tu pago pero hemos tenido problemas al procesar tu pedido. Por favor, contacta con nosotros.',
        ];
    }
}
?>