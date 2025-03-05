<?php

$tituloPagina = 'Mi Catalogo de Productos';
		
$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Mi Catálogo de Productos</h2>
            <div class="destacado">
                <ul>
                    <div class="destacado">
                    <a href="registerProducto_pantalla.php"><button>Añadir producto nuevo</button></a>
                    <p>Producto1</p>
                </ul>
            </div>
                            
            <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
            Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
            disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
    <script src="JS/registerProductoJS.js"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';

?>