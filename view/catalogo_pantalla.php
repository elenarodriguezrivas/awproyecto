<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo';
$rutaJS = RUTA_JS . "/listarProductosJS.js";

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2>Catálogo de Productos</h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
            <div id="perfil">
                <!-- Aquí se mostrarán los productos -->
                <div id="productos"></div>
            </div>
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>
