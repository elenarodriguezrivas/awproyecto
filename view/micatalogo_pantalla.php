<?php

$tituloPagina = 'Mi Catalogo de Productos';
		
$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Mi Catálogo de Productos</h2>
    <p>¡Bienvenido a tu catálogo de productos! Aquí podrás encontrar todos los productos que has puesto a la venta</p>
    <ul>
            <a href="registerProducto_pantalla.php"><button class="btn">Añadir producto nuevo </button></a>
            <a href="eliminarProducto_pantalla.php"><button class="btn">Eliminar producto </button></a>
    </ul>
    <div class="destacado">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <div id="perfil">
            <!-- Aquí se mostrarán los productos -->
            <div id="productos"></div>
        </div>
    </div>
    </section>
    <script src="JS/listarProductosUserJS.js"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';

?>