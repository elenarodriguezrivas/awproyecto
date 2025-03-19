<?php

$tituloPagina = 'Catalogo';

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Catálogo de Productos</h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
        <div class="destacado">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <div id="perfil">
                <!-- Aquí se mostrarán los productos -->
                <div id="productos"></div>
            </div>
        </div>
    </section>
    <script src="JS/listarProductosJS.js"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>