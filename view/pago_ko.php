<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = "Pago no realizado";
$contenidoPrincipal = <<<HTML
<div class="container mt-5 text-center">
    <div class="alert alert-danger p-5">
        <h2 class="mb-4">❌ Ha ocurrido un error con el pago</h2>
        <p class="lead">Tu operación de pago no ha podido completarse correctamente.</p>
        <p>Es posible que haya ocurrido uno de los siguientes problemas:</p>
        <ul class="text-start mt-3">
            <li>Cancelaste la operación durante el proceso de pago</li>
            <li>Los datos de la tarjeta no son correctos</li>
            <li>Tu banco ha rechazado la operación</li>
            <li>Ha ocurrido un error técnico en el procesamiento</li>
        </ul>
    </div>
    
    <div class="mt-4">
        <a href="/awproyecto/view/cesta_pantalla.php" class="btn btn-primary">Volver a la cesta</a>
        <a href="/awproyecto/index.php" class="btn btn-outline-secondary ms-2">Volver a la tienda</a>
    </div>
</div>
HTML;

require_once __DIR__ . '/../comun/plantilla.php';
?>