<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Pujas';
$rutaJS = RUTA_JS . "/listarPujasUserJS.js";
//Aquí se muestra las pujas que yo he puesto en otros productos que están subastados

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Pujas realizadas en Productos</h2>
        <p>Aquí podrás encontrar todas tus pujas realizadas para adquirir productos de segunda mano que han sido subastados o se encuentran en proceso de subasta.</p>
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