<?php
$tituloPagina = 'Registro de un producto';

$contenidoPrincipal = <<<EOS
    <h2 class="form-title">Nuevo producto</h2>
    <form id="registerForm" class="form">
        <div class="form-group">
            <label for="nombreProducto">Nombre producto:</label>
            <input type="text" id="nombreProducto" name="nombreProducto" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="descripcionProducto">Descripción producto:</label>
            <input type="text" id="descripcionProducto" name="descripcionProducto" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="categoriaProducto">Categoría del Producto:</label>
            <select id="categoriaProducto" name="categoriaProducto" required class="form-control">
                <option value="">Seleccione una categoría</option>
                <option value="computadora">Computadora</option>
                <option value="auriculares">Auriculares</option>
                <option value="juegos">Juegos</option>
                <option value="ratón">Ratón</option>
                <option value="teclado">Teclado</option>
                <option value="pantalla">Pantalla</option>
                <option value="impresora">Impresora</option>
                <option value="altavoces">Altavoces</option>                
            </select><br>
        </div>

        <div id="message" class="message"></div>

        <button type="submit" class="btn">Registrar producto</button>
    </form>

    <script src="JS/registerProductoJS.js"></script>
EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>