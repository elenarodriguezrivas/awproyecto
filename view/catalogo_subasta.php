<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo Subastas';
$rutaJS = RUTA_JS . "/listarSubastasUserJS.js";
//Aquí se muestra las subastas que yo he puesto de mis productos

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Catálogo de Productos en Subasta</h2>
        <p>¡Bienvenido a tu catálogo de productos en subasta! Aquí podrás encontrar tus productos subastados o en proceso de subasta.</p>
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