<?php

require_once __DIR__.'/../includes/config.php';

//falta verificar que el usuario es admin

$tituloPagina = 'Pantalla de administrador';

$rutaJS = RUTA_JS . '/listarCategoriasJS.js';

$contenidoPrincipal=<<<EOS
    <div class="bloque-contenido">
        <h2><strong>Pantalla de administrador</strong></h2>
        <div class="row">
            <div class = "col-sm-12 text-center ">
                Pulsa el boton para añadir una nueva categoria:           
                <a href="agregarCategoria_pantalla.php"><button class="btn">Agregar categoria</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class= "custom-container">
                    <div id="categorias">
                        <!-- Aquí se mostrarán las categorias -->
                     </div>
                </div>
            </div>
        </div>
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';

?>