<?php
$tituloPagina = 'Eliminar un producto';

$contenidoPrincipal = <<<EOS
<section class="presentacion">
    <h2 class="form-title">Eliminar un producto</h2>
    <div class="destacado">
        <p>¿Qué producto te gustaría eliminar? </p>
        <form method="post" action="eliminarProducto.php">
            <label for="nombreProducto">Nombre del Producto:</label>
            <input type="text" id="nombreProducto" name="nombreProducto" required>
            <button type="submit">Eliminar Producto</button>
        </form>
    </div>
</section>
<script src="JS/eliminarProductoJS.js"></script>
EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>