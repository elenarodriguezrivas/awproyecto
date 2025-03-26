<?php

require_once __DIR__.'/../includes/config.php';

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para registrar un producto.");
    exit;
}

$tituloPagina = 'Eliminar un producto';

$contenidoPrincipal = <<<EOS
<section class="presentacion">
    <h2 class="form-title">Eliminar un producto</h2>
    <div class="destacado">
        <p>¿Qué producto te gustaría eliminar?</p>
        <form id="deleteForm" action="#" method="POST" class="form">
            <label for="nombreProducto">Nombre del Producto:</label>
            <input type="text" id="nombreProducto" name="nombreProducto" required>
            <button type="submit">Eliminar Producto</button>
        </form>
        <div id="message"></div>
    </div>
</section>
<script src="JS/eliminarProductoJS.js"></script>
EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>
