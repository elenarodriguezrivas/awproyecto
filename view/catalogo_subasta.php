<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Mi Catalogo Subastas';
$rutaJS = RUTA_JS . "/listarSubastasUserJS.js";
//Aquí se muestra las subastas que yo he puesto de mis productos

$contenidoPrincipal=<<<EOS
    <div class="bloque-contenido">
        <h2>Mi Catálogo de Subastas</h2>
        <p>¡Bienvenido a tu catálogo de subasta! Aquí podrás encontrar tus productos subastados o en proceso de subasta.</p>
        <div class="row">
            <div class = "col-sm-12 text-center ">
                Pulsa el boton para añadir una nueva subasta:           
                <a href="registerSubasta_pantalla.php"><button class="btn">Añadir subasta nueva </button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="bloque-subastas">
                    <div class= "custom-container">
                        <div id="subastas">
                            <!-- Aquí se mostrarán las subastas -->
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