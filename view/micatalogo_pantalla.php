<?php

//hola
require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Mi Catalogo de Productos';

$rutaJS = RUTA_JS . '/listarProductosUserJS.js';

$contenidoPrincipal=<<<EOS
    <div class="bloque-contenido">
        <h2>Mi Catálogo de Productos</h2>
        <div class="row">
            <div class = "col-sm-12 text-center ">
                Pulsa el boton para añadir un nuevo producto a la venta:           
                <a href="registerProducto_pantalla.php"><button class="btn">Añadir producto nuevo </button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="bloque-productos">
                    <div class= "custom-container">
                        <div id="productos">
                            <!-- Aquí se mostrarán los productos -->
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