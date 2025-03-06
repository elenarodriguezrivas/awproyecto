<?php

$tituloPagina = 'Catalogo';

$contenidoPrincipal = <<<EOS
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="perfil">
        <!-- Aquí se mostrarán los productos -->
        <div id="productos"></div>
    </div>

    <script src="JS/listarProductosJS.js"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>