<?php
session_start();

require_once __DIR__.'/../includes/config.php';

// Verificar si el usuario tiene el rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login_pantalla.php?error=Acceso restringido.");
    exit;
}

$rutaJS = RUTA_JS . '/agregarCategoriaJS.js';

$tituloPagina = 'Crear Categoría';

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Crear una nueva categoría</strong></h2>
        <form id="categoriasForm" method="POST">
            <div class="form-group">
                <label for="categoria">Nombre de la categoría:</label>
                <input id="categoria" type="text" name="categoria" required class="form-control">
            </div>
            <div class="form-group">
                <a href="administrador_pantalla.php" class="btn">Volver</a>
                <button type="submit" class="btn">Guardar</button>
            </div>
        </form>
        <div id="message"></div> <!-- Este div mostrará el mensaje de éxito/error -->
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>