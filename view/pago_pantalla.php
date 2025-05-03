<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/Cestas/sa/obtenerCestaSA.php';

session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php");
    exit;
}

// Obtener cesta
$cestaSA = new obtenerCestaSA();
$cesta = $cestaSA->obtenerCesta($_SESSION['userid']);
$productos = $cesta ? $cesta->getProductosCesta() : [];

if (empty($productos)) {
    header("Location: cesta_pantalla.php?error=La cesta está vacía");
    exit;
}

$total = array_reduce($productos, fn($sum, $p) => $sum + $p->getPrecio(), 0) + 4.99; // + envío

$tituloPagina = 'Proceso de Pago';
$rutaJS = RUTA_JS . "/pagoJS.js";

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
    <h2 class="text-center mb-4">Finalizar Compra</h2>
    
    <div class="row">
        <!-- Formulario de pago -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Método de Pago</h5>
                </div>
                <div class="card-body">
                    <form id="formPago">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodoPago" id="tarjeta" value="tarjeta" checked>
                                <label class="form-check-label" for="tarjeta">
                                    <i class="bi bi-credit-card"></i> Tarjeta de crédito/débito
                                </label>
                            </div>
                        </div>
                        
                        <!-- Campos para tarjeta -->
                        <div id="tarjetaFields">
                            <div class="mb-3">
                                <label for="numeroTarjeta" class="form-label">Número de tarjeta</label>
                                <input type="text" class="form-control" id="numeroTarjeta" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fechaExpiracion" class="form-label">Fecha expiración (MM/AA)</label>
                                    <input type="text" class="form-control" id="fechaExpiracion" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" required>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="totalCompra" value="{$total}">
                        <button type="submit" class="btn btn-success w-100">Pagar {$total} €</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Resumen de compra -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    {$resumenProductos}
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Envío:</span>
                        <span>4.99 €</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mt-2">
                        <span>Total:</span>
                        <span>{$total} €</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">¡Pago exitoso!</h5>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                <p class="mt-3">Se ha procesado tu pago correctamente.</p>
                <p>Total: <strong>{$total} €</strong></p>
            </div>
            <div class="modal-footer">
                <a href="cesta_pantalla.php" class="btn btn-primary">Ver mis pedidos</a>
                <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
            </div>
        </div>
    </div>
</div>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>