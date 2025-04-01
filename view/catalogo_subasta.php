<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo Subastas';
$rutaJS = RUTA_JS . "/listarSubastasJS.js";

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Catálogo de Productos en Subasta</h2>
        <p>¡Bienvenido a nuestro catálogo de productos en subasta! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles que han sido subastados o se encuentran en proceso de subasta.</p>
        <div class="destacado">
            <div id="perfil">
                <!-- Aquí se mostrarán los productos -->
                <div id="productos"></div>
            </div>
        </div>
    </section>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>