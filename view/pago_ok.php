<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/database/Connection.php';
require_once __DIR__.'/../includes/Cestas/sa/vaciarCestaSA.php';
require_once __DIR__.'/../includes/Cestas/sa/obtenerCestaSA.php';

// Iniciar sesión para acceder al ID del usuario
session_start();

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
$mensajeAdicional = "";

/**
 * Procesa un pago exitoso:
 * 1. Actualiza el estado del pedido a "completado"
 * 2. Marca los productos como vendidos
 * 3. Registra las ventas
 * 4. Vacía la cesta del usuario
 * 
 * @param string $userId ID del usuario
 * @param string $orderId ID del pedido (opcional)
 * @return bool True si el proceso fue exitoso, False en caso contrario
 */
function procesarPagoExitoso($userId) {
    try {
        // Obtenemos la cesta actual antes de vaciarla
        $cestaSA = new obtenerCestaSA();
        $cesta = $cestaSA->obtenerCesta($userId);
        
        if (!$cesta) {
            // No hay cesta que procesar
            return false;
        }
        
        $productos = $cesta->getProductosCesta();
        
        if (empty($productos)) {
            // La cesta está vacía
            return false;
        }
        
        $db = DB::getInstance();
        $db->getBD()->beginTransaction();
        
        // 1. Obtener el último pedido del usuario (el más reciente)
        $stmt = $db->query(
            "SELECT orderId FROM Pedidos WHERE userId = ? ORDER BY fecha DESC LIMIT 1", 
            [$userId]
        );
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($pedido) {
            // Actualizar el estado del pedido a completado
            $orderId = $pedido['orderId'];
            $db->query("UPDATE Pedidos SET estado = 'completado' WHERE orderId = ?", [$orderId]);
        }
        
        // 2. Marcar los productos como vendidos
        foreach ($productos as $producto) {
            $productoId = $producto->getId();
            
            // Actualizar estado del producto a "vendido"
            $db->query("UPDATE Productos SET estado = 'vendido' WHERE id = ?", [$productoId]);
            
            // 3. Registrar la venta en la tabla Ventas
            $idVendedor = $producto->getIdVendedor();
            
            // Comprobar si ya existe esta venta para evitar duplicados
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
        
        // 4. Vaciar la cesta del usuario
        $vaciarCestaSA = new vaciarCestaSA();
        $vaciarCestaSA->vaciarCesta($userId);
        
        $db->getBD()->commit();
        return true;
        
    } catch (Exception $e) {
        // Si hay error, hacer rollback
        if (isset($db) && $db->getBD()->inTransaction()) {
            $db->getBD()->rollBack();
        }
        
        // Registrar el error en un log
        error_log("Error al procesar pago exitoso: " . $e->getMessage());
        return false;
    }
}

// Si tenemos un usuario en sesión, procesamos el pago
if ($userId) {
    // Procesar el pago (vaciar cesta y marcar productos como vendidos)
    $procesadoCorrectamente = procesarPagoExitoso($userId);
    
    // Mensaje personalizado basado en el resultado
    if ($procesadoCorrectamente) {
        $mensajeAdicional = <<<HTML
        <p>Tu pedido ha sido procesado correctamente y recibirás un correo electrónico con los detalles.</p>
        <p>Puedes revisar el estado de tus compras en tu perfil de usuario.</p>
        HTML;
        
        // Registrar en el log que se procesó correctamente
        error_log("Pago procesado correctamente para el usuario: $userId");
    } else {
        $mensajeAdicional = <<<HTML
        <p>Hemos registrado tu pago pero hemos tenido problemas al procesar tu pedido.</p>
        <p>Por favor, contacta con nosotros para resolver cualquier problema.</p>
        HTML;
        
        // Registrar en el log que hubo un problema
        error_log("Error al procesar el pago para el usuario: $userId");
    }
} else {
    // No hay usuario en sesión
    $mensajeAdicional = <<<HTML
    <p>No pudimos identificar tu sesión. Si crees que esto es un error, por favor contacta con atención al cliente.</p>
    HTML;
    
    // Registrar en el log el error
    error_log("Intento de acceso a pago_ok.php sin sesión de usuario");
}

$tituloPagina = "Pago realizado correctamente";
$contenidoPrincipal = <<<HTML
<div class="container mt-5 text-center">
    <div class="alert alert-success p-5">
        <h1 class="display-4">✅ ¡Gracias por tu compra!</h1>
        <p class="lead">Tu pago se ha realizado con éxito.</p>
        $mensajeAdicional
    </div>
    
    <div class="mt-4">
        <a href="/awproyecto/index.php" class="btn btn-primary">Volver a la tienda</a>
        <!--a href="/awproyecto/view/perfil_usuario.php" class="btn btn-outline-secondary ms-2">Ver mi perfil</a-->
    </div>
</div>
HTML;

require_once __DIR__ . '/../comun/plantilla.php';
?>