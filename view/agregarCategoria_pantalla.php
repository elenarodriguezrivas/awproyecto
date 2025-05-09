<?php

require_once __DIR__.'/../includes/config.php';

// Si el usuario no es un admin
/*if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { //Debe ser un admin
    header("Location: index.php?error=Acceso restringido.");
    exit;
}*/

$rutaJS = RUTA_JS . '/agregarCategoriaJS.js';

// Definir el contenido principal que se mostrará en la plantilla
$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Agrega una categoria</strong></h2>
        <form id="categoriasForm" method="POST">
            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <input id="categoria" type="text" name="categoria" required class="form-control">
            </div>
            <div class="form-group">
                <a href="administrador_pantalla.php" class="btn">Volver</a>
                <button type="submit" class="btn">Agregar</button>
            </div>
        </form>
        <div id="message"></div> <!-- Este div mostrará el mensaje de éxito/error -->
    </div>
    <script src="$rutaJS"></script>
EOS;


// Si hay un error, mostrarlo en la pantalla
if (isset($_GET['error'])) {
    $contenidoPrincipal .= "<p style='color:red;'>⚠️ " . htmlspecialchars($_GET['error']) . "</p>";
}

// Incluir la plantilla para que se muestre correctamente
require_once __DIR__ . '/../comun/plantilla.php';
?>