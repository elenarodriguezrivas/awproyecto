<?php
session_start();

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/formulario/FormularioModificarSubasta.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para modificar una subasta.");
    exit;
}

// Verificar si se proporciona un ID de subasta
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: catalogo_subasta.php?error=ID de subasta no válido.");
    exit;
}

$subastaId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$subastaId) {
    header("Location: catalogo_subasta.php?error=ID de subasta no válido.");
    exit;
}

$tituloPagina = 'Modificar Subasta';
$rutaJS = RUTA_JS . '/modificarSubastaJS.js';

// Crear instancia del formulario
$form = new FormularioModificarProducto($subastaId);
$htmlFormulario = $form->generaFormulario();

// Construir la página con el formulario
$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Modificar Producto</h2>
        <div class="destacado">
            $htmlFormulario
        </div>
    </section>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>