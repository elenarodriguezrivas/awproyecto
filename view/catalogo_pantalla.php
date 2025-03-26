<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo';
$rutaJS = RUTA_JS . "/listarProductosJS.js";

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Catálogo de Productos</h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
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