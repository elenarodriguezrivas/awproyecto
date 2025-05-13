<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Subastas';
$rutaJS = RUTA_JS . "/listarSubastasJS.js";
$rutaA1 = RUTA_IMGS . "/anuncio1.png";
$rutaA2 = RUTA_IMGS . "/anuncio2.png";
$rutaA3 = RUTA_IMGS . "/anuncio3.jpeg";
$rutaA4 = RUTA_IMGS . "/anuncio4.jpeg";

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
            <div class="d-none  d-md-block col-md-4">
                <div class = "bloque-anuncios">
                    <div class = "custom-container">
                        <div class="row">
                            <div class="col-12">
                                <div class = "bloque-anuncios-titulo">
                                    <strong>¡NVIDIA 5090 - Compra la nueva grafica de NVIDIA!</strong>
                                </div>
                                <div class = "bloque-anuncios-imagen">
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