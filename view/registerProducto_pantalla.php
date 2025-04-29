<?php
// Inicia la sesión al principio del archivo
session_start();

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/formulario/FormularioProducto.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: login_pantalla.php?error=Debes iniciar sesión para registrar un producto.");
    exit;
}

$rutaJS = RUTA_JS . '/registerProductoJS.js';

$tituloPagina = 'Registro de un producto';

// Crear instancia del formulario y gestionar su procesamiento
$form = new FormularioProducto();
$gestionFormulario = $form->generaFormulario();

// Construir la página con el formulario
$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Registro de un producto</strong></h2>
        <p> A continuación se podra añadir un nuevo producto a la venta.</p>
        <h3><strong>Nuevo producto</strong></h3>
        $gestionFormulario
        <div id="message" class="message"></div>
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>