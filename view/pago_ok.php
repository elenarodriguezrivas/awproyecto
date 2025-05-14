<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/controller/procesarPagoController.php';

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

// Llamar al controlador para procesar el pago
$mensajePago = procesarPago($userId);

if ($mensajePago['tipo'] === 'error') {
    // Redirigir a pago_ko.php si hay un error
    header("Location: /awproyecto/view/pago_ko.php");
    exit;
}

$tituloPagina = "Pago realizado correctamente";
$contenidoPrincipal = "";

if ($mensajePago) {
    $tipoAlerta = $mensajePago['tipo'] === 'success' ? 'alert-success' : 'alert-danger';
    $contenidoPrincipal = <<<HTML
    <div class="container mt-5 text-center">
        <div class="alert {$tipoAlerta} p-5">
            <h1 class="display-4">{$mensajePago['mensaje']}</h1>
        </div>
        <div class="mt-4">
            <a href="/index.php" class="btn btn-primary">Volver a la tienda</a>
        </div>
    </div>
    HTML;
} else {
    $contenidoPrincipal = <<<HTML
    <div class="container mt-5 text-center">
        <div class="alert alert-warning p-5">
            <h1 class="display-4">⚠️ No se encontró información del pago</h1>
            <p>Es posible que hayas accedido a esta página de forma incorrecta.</p>
        </div>
        <div class="mt-4">
            <a href="/index.php" class="btn btn-primary">Volver a la tienda</a>
        </div>
    </div>
    HTML;
}

require_once __DIR__ . '/../comun/plantilla.php';
?>
