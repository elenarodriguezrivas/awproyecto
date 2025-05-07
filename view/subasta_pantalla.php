<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Subastas';
$rutaJS = RUTA_JS . "/listarSubastasJS.js";
$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2 style="text-align: center">
            <strong>Subastas</strong>
        </h2>
        <p>¡Bienvenido a nuestra sección de productos en subasta! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles que han sido subastados o se encuentran en proceso de subasta.</p>
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="bloque-subastas">
                    <div class="custom-container">
                        <div id="subastas">
                            <!-- Aquí se mostrarán las subastas -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>