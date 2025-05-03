<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/Cestas/sa/obtenerCestaSA.php';
require_once __DIR__.'/../includes/redsys/apiRedsys.php';

session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php");
    exit;
}

// Obtener cesta
$cestaSA = new obtenerCestaSA();
$cesta = $cestaSA->obtenerCesta($_SESSION['userid']);
$productos = $cesta ? $cesta->getProductosCesta() : [];

$rutaImg = RUTA_IMGS;


if (empty($productos)) {
    header("Location: cesta_pantalla.php?error=La cesta está vacía");
    exit;
}

$total = array_reduce($productos, fn($sum, $p) => $sum + $p->getPrecio(), 0) + 4.99; // + envío

// Valores estáticos de prueba según documentación RedSys Sandbox
$fuc = "999008881"; // Código de comercio de pruebas
$terminal = "1";    // Número de terminal
$moneda = "978";    // Moneda: 978 = Euro
$trans = "0";       // Tipo de transacción: 0 = Autorización
$amount = intval($total * 100); // RedSys usa céntimos, así que multiplicamos por 100
$orderId = strtoupper(uniqid()); // ID único de pedido

$SECRET_KEY = "sq7HjrUOBfKmC576ILgskD5srU870gJ7"; // Clave secreta de pruebas (debe ser la misma que en el panel de RedSys)

// URLS de notificación y redirección tras pago
$urlNotificacion = ""; // pondre aqui la notificacion_pago.php pero hay que probar 
$urlOKKO = "http://localhost/ApiPhpRedsys/ApiRedireccion/redsysHMAC256_API_PHP_7.0.0/ejemploRecepcionaPet.php";

// Crear instancia del objeto RedsysAPI
$redsys = new RedsysAPI;

// Establecer parámetros obligatorios
$redsys->setParameter("DS_MERCHANT_AMOUNT", $amount);
$redsys->setParameter("DS_MERCHANT_ORDER", $orderId);
$redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$redsys->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);

// Establecer URLs de retorno
$redsys->setParameter("DS_MERCHANT_MERCHANTURL", $urlNotificacion); // Notificación (POST desde Redsys)
$redsys->setParameter("DS_MERCHANT_URLOK", $urlOKKO); // Redirección al pagar OK
$redsys->setParameter("DS_MERCHANT_URLKO", $urlOKKO); // Redirección al cancelar o fallar

// Generar los datos para el formulario
$version = "HMAC_SHA256_V1";
$params = $redsys->createMerchantParameters();
$signature = $redsys->createMerchantSignature($SECRET_KEY);
$tituloPagina = 'Proceso de Pago';

// Generar resumen de productos
$resumenProductos = '';
foreach ($productos as $producto) {
    $resumenProductos .= <<<EOS
    <div class="d-flex justify-content-between mb-2">
        <span>{$producto->getNombreProducto()}</span>
        <span>{$producto->getPrecio()} €</span>
    </div>
    EOS;
}

$contenidoPrincipal = <<<EOS
<div class="container mt-4">
    <h2 class="text-center mb-4">Resumen de Compra</h2>
    
    <div class="row justify-content-center">
        <!-- Resumen de compra -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detalles del Pedido</h5>
                </div>
                <div class="card-body">
                    <h6>Productos:</h6>
                    {$resumenProductos}
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Envío:</span>
                        <span>4.99 €</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mt-3">
                        <span>Total a pagar:</span>
                        <span>{$total} €</span>
                    </div>
                    
                    <!-- Formulario oculto para RedSys -->
                    <form id="formRedSys" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="POST">
                        <input type="hidden" name="Ds_SignatureVersion" value="{$version}">
                        <input type="hidden" name="Ds_MerchantParameters" value="{$params}">
                        <input type="hidden" name="Ds_Signature" value="{$signature}">
                        
                        <button type="submit" class="btn btn-success w-100 mt-4">
                            <i class="bi bi-credit-card"></i> Proceder al pago seguro
                        </button>
                    </form>
                    
                    <a href="cesta_pantalla.php" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left"></i> Volver a la cesta
                    </a>
                </div>
            </div>
            
            <div class="alert alert-info">
                <h6><i class="bi bi-shield-lock"></i> Pago seguro</h6>
                <p class="small mb-1">Todas las transacciones están protegidas con cifrado SSL</p>
                <div class="text-center mt-2">
                    <img src="{$rutaImg}/redsys-logo.png" alt="RedSys" style="height: 30px;" class="me-2">
                    <img src="{$rutaImg}/visa-mastercard.png" alt="Visa/Mastercard" style="height: 30px;">
                </div>
            </div>
        </div>
    </div>
</div>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>