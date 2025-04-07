<?php

//hola
require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Mi Catalogo de Productos';

$rutaJS = RUTA_JS . '/listarProductosUserJS.js';

$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Mi Catálogo de Productos</h2>
    <div class="destacado">
        <ul>
            <a href="registerProducto_pantalla.php"><button class="btn">Añadir producto nuevo </button></a>
    </ul>
    <div id="productos"></div>
    </div>
    </section>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';

?>