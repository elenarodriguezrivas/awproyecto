<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Mis Pujas';
$rutaJS = RUTA_JS . "/listarPujasUserJS.js";

$contenidoPrincipal=<<<EOS
    <div class="bloque-contenido">
        <h2>Mis Pujas</h2>
        <p> Aquí podrás encontrar tus pujas realizadas en productos subastados o en proceso de subasta.</p>
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="bloque-pujas">
                    <div class= "custom-container">
                        <div id="pujas">
                            <!-- Aquí se mostrarán las pujas -->
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