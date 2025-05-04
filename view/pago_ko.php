<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = "Pago no realizado";
$contenidoPrincipal = <<<HTML
<div class="container mt-5 text-center">
    <h2 class="text-success">Ha ocurrido un error </h2>
    <p></p>
    <a href="/awproyecto/index.php" class="btn btn-primary mt-3">Volver a la tienda</a>
</div>
HTML;

require_once __DIR__ . '/../comun/plantilla.php';
?>
