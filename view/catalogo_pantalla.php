<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo';
$rutaJS = RUTA_JS . "/listarProductosJS.js";
$rutaIMG = RUTA_IMGS . "elena.jpeg";
$rutaA2 = RUTA_IMGS . "fdi.png";

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2 style = "text-align: center">
            <strong>Catálogo de Productos</strong>
        </h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
        <div class = "row">
            <div class="col-12">
                <div class = "bloque-filtros">
                    <!-- Selector de categoría -->
                    <div class = "col-4 text-right"> <label for="selectorCategoria">Filtrar por categoría:</label> </div>
                    <div class = "col-8 text-left">
                        <select id="selectorCategoria" class="form-control" onchange="listarPorCategoriaProducto(this.value)">
                            <option value="">Todas las categorías</option>
                            <option value="computadora">Computadora</option>
                            <option value="auriculares">Auriculares</option>
                            <option value="juegos">Juegos</option>
                            <option value="ratón">Ratón</option>
                            <option value="teclado">Teclado</option>
                            <option value="pantalla">Pantalla</option>
                            <option value="impresora">Impresora</option>
                            <option value="altavoces">Altavoces</option>
                        </select>	
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-8 mx-auto">
                <div class="bloque-productos">
                    <div class= "custom-container">
                        <div id="productos">
                            <!-- Aquí se mostrarán los productos -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class = "bloque-anuncios">
                    <div class="row">
                        <div class="col">
                            <a href="#" target="_blank"><img src="<?= $rutaIMG ?>" class="img-fluid"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="#" target="_blank"><img src="<?= $rutaA2 ?>"class="img-fluid"></a>
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
