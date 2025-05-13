<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo';
$rutaJS = RUTA_JS . "/listarProductosJS.js";
$rutaA1 = RUTA_IMGS . "/anuncio1.png";
$rutaA2 = RUTA_IMGS . "/anuncio2.png";
$rutaA3 = RUTA_IMGS . "/anuncio3.jpeg";
$rutaA4 = RUTA_IMGS . "/anuncio4.jpeg";

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2 style="text-align: center">
            <strong>Catálogo de Productos</strong>
        </h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
        <div class="row">
            <div class="col-12">
                <div class="bloque-filtros">
                    <!-- Selector de categoría -->
                    <div class="col-4 text-right"> <label for="selectorCategoria">Filtrar por categoría:</label> </div>
                    <div class="col-8 text-left">
                        <select id="selectorCategoria" class="form-control" onchange="listarPorCategoriaProducto(this.value)">
                            <option value="">Todas las categorías</option>
                            <!-- Opciones se cargarán desde JS -->
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="bloque-productos">
                    <div class="custom-container">
                        <div id="productos" class="productos-grid">
                            <!-- Aquí se cargarán los productos mediante AJAX -->
                        </div>
                        <div id="paginacion" class="text-center mt-4">
                            <!-- Aquí se cargarán los enlaces de paginación -->
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <label for="productosPorPaginaSelector">Productos por página:</label>
                        <select id="productosPorPaginaSelector" class="form-control d-inline-block w-auto" onchange="cambiarProductosPorPagina(this.value)">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                </div>
                <!-- Contenedor para la paginación -->
                <div id="paginacion" class="paginacion">
                    <!-- Aquí se generará la paginación mediante JS -->
                </div>
            </div>
            <div class="d-none d-md-block col-md-4">
                <div class="bloque-anuncios">
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-12">
                                <div class="bloque-anuncios-titulo">
                                    <strong>¡NVIDIA 5090 - Compra la nueva gráfica de NVIDIA!</strong>
                                </div>
                                <div class="bloque-anuncios-imagen">
                                    <img src="$rutaA1" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>¡IPHONE 16 - El MEJOR del mercado actual!</strong></p>
                                <img src="$rutaA2" class="img-fluid">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p><strong>¡NINTENDO SWITCH2 - Novedad de la temporada!</strong></p>
                                <img src="$rutaA3" class="img-fluid">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>¡PLAY5 - Sigue arrasando!</strong></p>
                                <img src="$rutaA4" class="img-fluid">
                            </div>
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
