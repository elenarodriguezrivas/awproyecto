<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Catalogo';
$rutaJS = RUTA_JS . "/listarProductosJS.js";

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Catálogo de Productos</h2>
        <p>¡Bienvenido a nuestro catálogo de productos! Aquí podrás encontrar una amplia variedad de productos de segunda mano 
        a precios muy asequibles. ¡No te lo pierdas!</p>
        <div class="destacado">
            <!-- Selector de categoría -->
            <label for="selectorCategoria">Filtrar por categoría:</label>
            <select id="selectorCategoria" class="form-control">
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
            
            <div id="perfil">
                <!-- Aquí se mostrarán los productos -->
                <div id="productos"></div>
            </div>
        </div>
    </section>
    <script
     src="$rutaJS">
    
     </script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>