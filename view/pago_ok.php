<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = "Pago realizado correctamente";
$contenidoPrincipal = <<<HTML
<div class="container mt-5 text-center">
    <h2 class="text-success">✅ ¡Gracias por tu compra!</h2>
    <p>Tu pago se ha realizado con éxito.</p>
    <a href="/awproyecto/index.php" class="btn btn-primary mt-3">Volver a la tienda</a>
</div>
HTML;

require_once __DIR__ . '/../comun/plantilla.php';
?>
