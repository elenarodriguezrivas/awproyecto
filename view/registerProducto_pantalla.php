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

$tituloPagina = 'Registro de un producto';

// Crear instancia del formulario y gestionar su procesamiento
$form = new FormularioProducto();
$gestionFormulario = $form->gestiona();

// Construir la página con el formulario
$contenidoPrincipal = <<<EOS
    <h2 class="form-title">Nuevo producto</h2>
    $gestionFormulario
EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>