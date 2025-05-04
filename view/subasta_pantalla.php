<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Subastas';
$rutaJS = RUTA_JS . "/listarSubastasJS.js";
//Aqui se muestra todas las subastas que hay en la tabla subasta

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Mis productos en Subasta</h2>
        <p>¡Bienvenido a nuestra sección de productos en subasta! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
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
