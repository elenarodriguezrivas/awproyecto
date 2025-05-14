<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = "Error en el Pago";

$contenidoPrincipal = <<<HTML
<div class="container mt-5 text-center">
    <div class="alert alert-danger p-5">
        <h1 class="display-4">❌ Error en el Pago</h1>
        <p>Lo sentimos, ha ocurrido un problema al procesar tu pago.</p>
        <p>Por favor, inténtalo de nuevo más tarde o contacta con soporte.</p>
    </div>
    <div class="mt-4">
        <a href="/index.php" class="btn btn-primary">Volver a la tienda</a>
    </div>
</div>
HTML;

require_once __DIR__ . '/../comun/plantilla.php';
?>
