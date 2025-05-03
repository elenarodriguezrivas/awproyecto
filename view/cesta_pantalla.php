<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/Cestas/sa/obtenerCestaSA.php';

session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php");
    exit;
}

// Obtener productos de la cesta
$cestaSA = new obtenerCestaSA();
$cesta = $cestaSA->obtenerCesta($_SESSION['userid']);
$productos = $cesta ? $cesta->getProductosCesta() : [];

// Calcular total
$total = array_reduce($productos, fn($sum, $p) => $sum + $p->getPrecio(), 0);

$tituloPagina = 'Cesta de Compra';
$rutaJS = RUTA_JS . "/cestaJS.js";

// Generar lista de productos
$htmlProductos = '';
if (count($productos) > 0) {
    foreach ($productos as $producto) {
        $htmlProductos .= <<<EOS
        <div class="producto-cesta mb-3 p-3 border rounded">
            <div class="row">
                <div class="col-md-2">
                    <img src="../{$producto->getRutaImagen()}" alt="{$producto->getNombreProducto()}" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h5>{$producto->getNombreProducto()}</h5>
                    <p>{$producto->getDescripcionProducto()}</p>
                </div>
                <div class="col-md-2 text-end">
                    <p class="fw-bold">{$producto->getPrecio()} €</p>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-danger btn-sm" onclick="eliminarDeCesta({$producto->getId()})">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
        EOS;
    }
} else {
    $htmlProductos = '<div class="alert alert-info">Tu cesta está vacía.</div>';
}

$botonesCompra = '';
if (count($productos) > 0) {
    $totalConEnvio = $total + 4.99;
    $botonesCompra = <<<EOS
    <p class="d-flex justify-content-between">
        <span>Subtotal:</span>
        <span>{$total} €</span>
    </p>
    <p class="d-flex justify-content-between">
        <span>Envío:</span>
        <span>4.99 €</span>
    </p>
    <hr>
    <p class="d-flex justify-content-between fw-bold">
        <span>Total:</span>
        <span>{$totalConEnvio} €</span>
    </p>
    <a href="pago_pantalla.php" class="btn btn-success w-100 mt-3">
        Proceder al pago
    </a>
    <button id="vaciar-cesta" class="btn btn-outline-danger w-100 mt-2">
        Vaciar cesta completa
    </button>
    EOS;
} else {
    $botonesCompra = <<<EOS
    <p>No hay productos en la cesta</p>
    <a href="catalogo_pantalla.php" class="btn btn-primary w-100 mt-3">
        Continuar comprando
    </a>
    EOS;
}

$contenidoPrincipal = <<<EOS
<div class="container mt-4">
    <h2 class="text-center mb-4">Mi Cesta de Compra</h2>

    <div id="mensaje-accion" class="alert" style="display: none;"></div>

    <div class="row">
        <!-- Lista de productos -->
        <div class="col-md-8">
            {$htmlProductos}
        </div>
        
        <!-- Resumen -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Resumen</h5>
                </div>
                <div class="card-body">
                    {$botonesCompra}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$rutaJS}"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>