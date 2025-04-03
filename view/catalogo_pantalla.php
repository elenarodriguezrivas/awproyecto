<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo';
$rutaJS = RUTA_JS . "/listarProductosJS.js";

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2 style = "text-align: center">
            <strong>Catálogo de Productos</strong>
        </h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
       <div class="row">
            <div class="col-sm-2 d-none d-sm-block">
                <div class = "bloque-izquierda">
                    <p>CATEGORÍAS</p>
                </div>
            </div>
            <div class="col-sm-8 mx-auto">
                <div class="bloque-productos">
                    <div class= "custom-container">
                        <div id="productos">
                            <!-- Aquí se mostrarán los productos -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 d-none d-sm-block">
                <div class = "bloque-derecha">
                    <p>FOTOS</p>
                </div>
            </div>
        </div>
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>
