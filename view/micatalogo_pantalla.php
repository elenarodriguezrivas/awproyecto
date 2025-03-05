<?php

$tituloPagina = 'Mi Catalogo de Productos';
		
$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Mi Catálogo de Productos</h2>
            <div class="destacado">
                <ul>
                    <div class="destacado">
                    <a href="registerProducto_pantalla.php"><button>Añadir producto nuevo</button></a>
                    <a href="eliminarProducto_pantalla.php"><button>Eliminar producto </button></a>
                </ul>
            </div>
    </section>
    <script src="JS/registerProductoJS.js"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';

?>