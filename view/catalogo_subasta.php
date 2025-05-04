<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Mi Catalogo Subastas';
$rutaJS = RUTA_JS . "/listarSubastasUserJS.js";
//Aquí se muestra las subastas que yo he puesto de mis productos

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Mi Catálogo de Productos en Subasta</h2>
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

$contenidoPrincipal=<<<EOS
    <div class="bloque-contenido">
        <h2>Mi Catálogo de Productos en Subasta</h2>
        <div class="row">
            <div class = "col-sm-12 text-center ">
                Pulsa el boton para añadir un nuevo producto a subastar:           
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