<?php
require_once __DIR__.'/../includes/config.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para realizar el pago.");
    exit;
}

$tituloPagina = 'Proceso de Pago';
$rutaJS = RUTA_JS . "/pagoJS.js";

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2 style="text-align: center">
            <strong>Finalizar Compra</strong>
        </h2>
        
        <!-- Mensajes de alerta -->
        <div id="mensajes" class="mensajes-container mb-3"></div>
        
        <!-- Contenedor del proceso de pago -->
        <div id="pago-container">
            <div class="row">
                <!-- Formulario de pago -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Información de pago</h4>
                        </div>
                        <div class="card-body">
                            <form id="formPago" class="needs-validation" novalidate>
                                <!-- Selección de método de pago -->
                                <div class="mb-4">
                                    <h5>Método de pago</h5>
                                    <div class="btn-group-vertical w-100" role="group">
                                        <div class="form-check border p-3 rounded mb-2">
                                            <input class="form-check-input" type="radio" name="metodoPago" id="metodoTarjeta" value="tarjeta" checked>
                                            <label class="form-check-label w-100" for="metodoTarjeta">
                                                <i class="bi bi-credit-card"></i> Tarjeta de crédito/débito
                                            </label>
                                        </div>
                                        <div class="form-check border p-3 rounded mb-2">
                                            <input class="form-check-input" type="radio" name="metodoPago" id="metodoPaypal" value="paypal">
                                            <label class="form-check-label w-100" for="metodoPaypal">
                                                <i class="bi bi-paypal"></i> PayPal
                                            </label>
                                        </div>
                                        <div class="form-check border p-3 rounded">
                                            <input class="form-check-input" type="radio" name="metodoPago" id="metodoTransferencia" value="transferencia">
                                            <label class="form-check-label w-100" for="metodoTransferencia">
                                                <i class="bi bi-bank"></i> Transferencia bancaria
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Formulario de tarjeta de crédito -->
                                <div id="tarjeta-form" class="metodo-pago-form">
                                    <h5>Datos de la tarjeta</h5>
                                    <div class="mb-3">
                                        <label for="nombreTarjeta" class="form-label">Nombre en la tarjeta</label>
                                        <input type="text" class="form-control" id="nombreTarjeta" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numeroTarjeta" class="form-label">Número de tarjeta</label>
                                        <input type="text" class="form-control" id="numeroTarjeta" placeholder="XXXX XXXX XXXX XXXX" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fechaExpiracion" class="form-label">Fecha de expiración</label>
                                            <input type="text" class="form-control" id="fechaExpiracion" placeholder="MM/AA" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Formulario de PayPal -->
                                <div id="paypal-form" class="metodo-pago-form" style="display: none;">
                                    <div class="text-center p-4">
                                        <img src="../includes/img/paypal-logo.png" alt="PayPal" style="max-width: 200px;">
                                        <p class="mt-3 text-muted">Serás redirigido a PayPal para completar el pago de forma segura.</p>
                                    </div>
                                </div>
                                
                                <!-- Formulario de transferencia bancaria -->
                                <div id="transferencia-form" class="metodo-pago-form" style="display: none;">
                                    <div class="alert alert-info">
                                        <h5>Datos para la transferencia</h5>
                                        <p><strong>Banco:</strong> Banco MercaSwapp</p>
                                        <p><strong>Beneficiario:</strong> MercaSwapp S.L.</p>
                                        <p><strong>IBAN:</strong> ES91 2100 0418 4502 0005 1332</p>
                                        <p><strong>Concepto:</strong> Pedido #<span id="referencia-pedido">SW-{$_SESSION['userid']}-</span></p>
                                        <p class="mb-0"><small>Recibirás un correo con estas instrucciones.</small></p>
                                    </div>
                                </div>
                                
                                <!-- Campo oculto para el total -->
                                <input type="hidden" id="totalCompra" name="totalCompra" value="0">
                                
                                <!-- Botón de envío -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">Realizar pago</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Resumen de la compra -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">Resumen del pedido</h4>
                        </div>
                        <div class="card-body">
                            <div id="resumen-compra">
                                <!-- Aquí se cargará el resumen dinámicamente con JavaScript -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <h5>Total a pagar:</h5>
                                <h5><span id="total-pago">0.00</span>€</h5>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Pago seguro</h5>
                        </div>
                        <div class="card-body">
                            <p><i class="bi bi-shield-check"></i> Todas las transacciones son seguras y encriptadas.</p>
                            <p><i class="bi bi-lock"></i> Tus datos nunca se almacenan en nuestros servidores.</p>
                            <div class="text-center mt-3">
                                <img src="../includes/img/redsys-logo.png" alt="RedSys" style="height: 30px; margin-right: 10px;">
                                <img src="../includes/img/visa-logo.png" alt="Visa" style="height: 30px; margin-right: 10px;">
                                <img src="../includes/img/mastercard-logo.png" alt="MasterCard" style="height: 30px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botón para volver a la cesta -->
            <div class="text-center mt-4">
                <a href="cesta_pantalla.php" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Volver a la cesta
                </a>
            </div>
        </div>
        
        <!-- Contenedor de simulación de RedSys -->
        <div id="redsys-container" style="display: none;">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-header bg-dark text-white text-center">
                    <img src="../includes/img/redsys-logo.png" alt="RedSys" style="height: 40px;">
                    <h5 class="mt-2 mb-0">Pasarela de Pago Seguro</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info text-center">
                        <small>Estás en un entorno de simulación. En una implementación real, serías redirigido a la pasarela de pago del banco.</small>
                    </div>
                    
                    <div class="mb-4 text-center">
                        <p>Confirma el pago de:</p>
                        <h3 class="text-primary"><span id="redsys-total">0.00</span>€</h3>
                        <p>Para <strong>MercaSwapp S.L.</strong></p>
                    </div>
                    
                    <div class="mb-4">
                        <div class="progress" style="height: 25px;">
                            <div id="redsys-progress" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%"></div>
                        </div>
                        <p id="redsys-status" class="text-center mt-2">Conectando con el servidor de pago...</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button id="redsys-cancelar" class="btn btn-outline-danger w-100">Cancelar</button>
                        </div>
                        <div class="col-md-6">
                            <button id="redsys-confirmar" class="btn btn-success w-100">Confirmar pago</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">Transacción protegida por SSL/TLS - Redsys © 2025</small>
                </div>
            </div>
        </div>
        
        <!-- Mensaje de confirmación -->
        <div id="confirmacion-container" style="display: none;">
            <div class="text-center my-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h3>¡Pago completado con éxito!</h3>
                <p class="text-muted">Hemos recibido tu pago correctamente.</p>
                <p>Número de pedido: <strong><span id="numero-pedido">SW-00000</span></strong></p>
                <p>Se ha enviado un correo de confirmación a tu dirección de email.</p>
                
                <div class="mt-4">
                    <a href="mis_pedidos_pantalla.php" class="btn btn-primary me-2">
                        <i class="bi bi-bag-check"></i> Ver mis pedidos
                    </a>
                    <a href="index_pantalla.php" class="btn btn-outline-secondary">
                        <i class="bi bi-house"></i> Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
EOS;

// Incluir la plantilla general
require_once RUTA_PLANTILLAS . '/plantilla.php';

// Función para procesar el pago (esta se activaría por AJAX desde pagoJS.js)
if (isset($_POST['accion']) && $_POST['accion'] === 'procesarPago') {
    // Validar CSRF token (debería implementarse)
    
    // Recuperar datos del POST
    $metodoPago = isset($_POST['metodoPago']) ? htmlspecialchars($_POST['metodoPago']) : '';
    $totalCompra = isset($_POST['totalCompra']) ? floatval($_POST['totalCompra']) : 0;
    
    // Verificar que los datos son válidos
    if (empty($metodoPago) || $totalCompra <= 0) {
        echo json_encode(['exito' => false, 'mensaje' => 'Datos de pago inválidos']);
        exit;
    }
    
    // Recuperar información del carrito desde la sesión
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
    
    if (empty($carrito)) {
        echo json_encode(['exito' => false, 'mensaje' => 'No hay productos en el carrito']);
        exit;
    }
    
    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo json_encode(['exito' => false, 'mensaje' => 'Error de conexión a la base de datos']);
        exit;
    }
    
    // Iniciar transacción
    $conn->begin_transaction();
    
    try {
        // Crear el pedido en la tabla 'pedidos'
        $userId = $_SESSION['userid'];
        $fechaActual = date('Y-m-d H:i:s');
        $estado = ($metodoPago === 'transferencia') ? 'pendiente' : 'pagado';
        
        $sqlPedido = "INSERT INTO pedidos (usuario_id, fecha_pedido, metodo_pago, total, estado) 
                      VALUES (?, ?, ?, ?, ?)";
        
        $stmtPedido = $conn->prepare($sqlPedido);
        $stmtPedido->bind_param("issds", $userId, $fechaActual, $metodoPago, $totalCompra, $estado);
        $stmtPedido->execute();
        
        // Obtener el ID del pedido insertado
        $pedidoId = $conn->insert_id;
        
        // Insertar los detalles del pedido en 'detalles_pedido'
        $sqlDetalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario) 
                       VALUES (?, ?, ?, ?)";
        
        $stmtDetalle = $conn->prepare($sqlDetalle);
        
        foreach ($carrito as $productoId => $item) {
            $cantidad = $item['cantidad'];
            $precioUnitario = $item['precio'];
            
            $stmtDetalle->bind_param("iiid", $pedidoId, $productoId, $cantidad, $precioUnitario);
            $stmtDetalle->execute();
            
            // Actualizar el stock del producto
            $sqlStock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
            $stmtStock = $conn->prepare($sqlStock);
            $stmtStock->bind_param("ii", $cantidad, $productoId);
            $stmtStock->execute();
        }
        
        // Confirmar la transacción
        $conn->commit();
        
        // Limpiar el carrito en la sesión
        $_SESSION['carrito'] = [];
        
        // Generar número de referencia para el pedido
        $referenciaPedido = "SW-" . $userId . "-" . $pedidoId;
        
        // Devolver respuesta exitosa
        echo json_encode([
            'exito' => true, 
            'mensaje' => 'Pago procesado correctamente', 
            'pedidoId' => $pedidoId,
            'referencia' => $referenciaPedido
        ]);
        
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        
        echo json_encode([
            'exito' => false, 
            'mensaje' => 'Error al procesar el pago: ' . $e->getMessage()
        ]);
    }
    
    // Cerrar conexión y statements
    $stmtPedido->close();
    $stmtDetalle->close();
    if (isset($stmtStock)) {
        $stmtStock->close();
    }
    $conn->close();
    
    exit;
}
?>