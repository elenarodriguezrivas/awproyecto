<?php
$tituloPagina = 'Eliminar un producto';

$contenidoPrincipal = <<<EOS
<form method="post" action="eliminarProducto.php">
    <label for="nombreProducto">Nombre del Producto:</label>
    <input type="text" id="nombreProducto" name="nombreProducto" required>
    <button type="submit">Eliminar Producto</button>
</form>
<script src="JS/eliminarProductoJS.js"></script>
EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>