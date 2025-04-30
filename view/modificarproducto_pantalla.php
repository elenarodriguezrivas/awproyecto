<?php
session_start();

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/formulario/FormularioModificarProducto.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para modificar un producto.");
    exit;
}

// Verificar si se proporciona un ID de producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: micatalogo_pantalla.php?error=ID de producto no válido.");
    exit;
}

$productoId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$productoId) {
    header("Location: micatalogo_pantalla.php?error=ID de producto no válido.");
    exit;
}

$tituloPagina = 'Modificar Producto';
$rutaJS = RUTA_JS . '/modificarProductoJS.js';

// Crear instancia del formulario y llamar a initialize
$form = new FormularioModificarProducto($productoId);
$form->initialize(); // Inicializar el formulario (carga los datos del producto)
$htmlFormulario = $form->generaFormulario(); // Generar el HTML del formulario

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