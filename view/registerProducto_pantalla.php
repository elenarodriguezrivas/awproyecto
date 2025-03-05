<?php
$tituloPagina = 'Registro de un producto';

$contenidoPrincipal = <<<EOS
    <h2 class="form-title">Nuevo producto</h2>
    <form id="registerForm" action="../includes/controller/registerProducto_pantalla.php" method="POST" class="form">
        <div class="form-group">
            <label for="id">Id:</label>
            <input type="text" id="id" name="id" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="nombreProducto">Nombre producto:</label>
            <input type="nombreProducto" id="nombreProducto" name="nombreProducto" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="descripcionProducto">Descripción producto:</label>
            <input type="descripcionProducto" id="descripcionProducto" name="descripcionProducto" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="precio" id="precio" name="precio" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="categoriaProducto">Categoría del Producto:</label>
            <input type="categoriaProducto" id="categoriaProducto" name="categoriaProducto" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="fechaRegistroProducto">Fecha registro del producto (YYYYMMDD):</label>
            <input type="number" id="fechaRegistroProducto" name="fechaRegistroProducto" class="form-control"><br>
        </div>

        <div id="message" class="message"></div>

        <input type="hidden" name="action" value="register">
        <button type="submit" class="btn">Registrarse</button>

    </form>

    <p>¿Ya tienes cuenta? <a href="login_pantalla.php">Inicia sesión aquí</a></p>

     <script src="JS/registerProductoJS.js"></script>


EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>