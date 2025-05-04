<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/redsys/apiRedsys.php';
require_once __DIR__.'/../includes/Cestas/sa/obtenerCestaSA.php';
require_once __DIR__.'/../includes/database/Connection.php'; // Agregar la inclusión de la clase DB

$miObj = new RedsysAPI;

if (!empty($_POST)) {
    $version = $_POST["Ds_SignatureVersion"];
    $params = $_POST["Ds_MerchantParameters"];
    $signatureRecibida = $_POST["Ds_Signature"];
    
    // Verificar firma
    $firmaCalculada = $miObj->createMerchantSignatureNotif(SECRET_KEY, $params);
    
    if ($firmaCalculada === $signatureRecibida) {
        $decodec = $miObj->decodeMerchantParameters($params);
        $order = $decodec['Ds_Order'];
        $response = $decodec['Ds_Response'];
        
        // Comprobar que la respuesta es un pago exitoso
        // Los códigos de respuesta exitosos están entre 0 y 99
        if (intval($response) >= 0 && intval($response) <= 99) {
            // Procesar el pago exitoso
            procesarPagoExitoso($order);
        }
        
        // Registrar la respuesta en tu base de datos
        registrarRespuestaPago($order, $response, $params);
    }
    
    // RedSys espera una respuesta vacía
    exit;
}

function procesarPagoExitoso($orderId) {
    // Obtener la instancia de la conexión
    $db = DB::getInstance();
    
    try {
        // 1. Obtener el usuario asociado a este pedido
        $stmt = $db->query("SELECT userId FROM Pedidos WHERE orderId = ?", [$orderId]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$pedido) {
            file_put_contents('error_pagos.log', "[".date('Y-m-d H:i:s')."] Order: $orderId - No se encontró el pedido en la base de datos\n", FILE_APPEND);
            return;
        }
        
        $userId = $pedido['userId'];
        
        // 2. Obtener los productos en la cesta del usuario
        $stmt = $db->query("SELECT p.* FROM Productos p 
                          JOIN Cestas c ON p.id = c.productoId 
                          WHERE c.userId = ?", [$userId]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($productos)) {
            file_put_contents('error_pagos.log', "[".date('Y-m-d H:i:s')."] Order: $orderId - Cesta vacía para usuario: $userId\n", FILE_APPEND);
            return;
        }
        
        // Obtener la conexión PDO para la transacción
        $conn = $db->getBD();
        
        // Iniciar transacción para garantizar que todas las operaciones se completen o ninguna
        $conn->beginTransaction();
        
        foreach ($productos as $producto) {
            $productoId = $producto['id'];
            $vendedorId = $producto['idVendedor'];
            
            // 3. Cambiar el estado del producto a "vendido"
            $stmt = $conn->prepare("UPDATE Productos SET estado = 'vendido' WHERE id = ?");
            $stmt->execute([$productoId]);
            
            // 4. Registrar la venta en la tabla Ventas
            $stmt = $conn->prepare("INSERT INTO Ventas (producto_id, vendedor_id, comprador_id) VALUES (?, ?, ?)");
            $stmt->execute([$productoId, $vendedorId, $userId]);
        }
        
        // 5. Vaciar la cesta del usuario
        $stmt = $conn->prepare("DELETE FROM Cestas WHERE userId = ?");
        $stmt->execute([$userId]);
        
        // 6. Actualizar el estado del pedido a "pagado"
        $stmt = $conn->prepare("UPDATE Pedidos SET estado = 'pagado' WHERE orderId = ?");
        $stmt->execute([$orderId]);
        
        // Confirmar todas las operaciones
        $conn->commit();
        
        // Registrar el éxito de la operación
        file_put_contents('pagos_exitosos.log', "[".date('Y-m-d H:i:s')."] Order: $orderId, Usuario: $userId - Procesado correctamente\n", FILE_APPEND);
        
    } catch (Exception $e) {
        // Si algo sale mal, deshacer todas las operaciones
        if (isset($conn) && $conn->inTransaction()) {
            $conn->rollBack();
        }
        file_put_contents('error_pagos.log', "[".date('Y-m-d H:i:s')."] Order: $orderId - Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
}

function registrarRespuestaPago($order, $response, $params) {
    // Implementa tu lógica para guardar la respuesta
    // Ejemplo básico:
    file_put_contents('pagos.log', "[".date('Y-m-d H:i:s')."] Order: $order, Response: $response\nParams: $params\n\n", FILE_APPEND);
}