<?php

$tituloPagina = 'Catalogo de Productos';
		
$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Catalogo de Productos</h2>
            <div class="destacado">
                <ul>
                    <div class="destacado">
                    <p>Producto1</p>
                    <p>Producto2</p>
                    <p>Producto3</p>
                    <p>Producto4</p>
                    <p>Producto5</p>
                    <p>Producto6</p>
                </ul>
            </div>
                            
            <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
            Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
            disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
EOS;

require("comun/plantilla.php");
?>