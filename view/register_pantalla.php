<?php

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/formulario/FormularioRegistro.php';

// Si el usuario ya está autenticado, redirigir al perfil
if (isset($_SESSION['userid'])) {
    header("Location: perfil_pantalla.php");
    exit;
}

$rutaJS = RUTA_JS . '/registerJS.js';

// Crear una instancia del formulario de registro
$formularioRegistro = new FormularioRegistro();
$htmlFormulario = $formularioRegistro->generaFormulario();

// Definir el contenido principal que se mostrará en la plantilla
$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2 class="form-title">Regístrate en MercaSwapp</h2>
        <div class="destacado">
            $htmlFormulario
            <div id="message" class="message"></div>
        </div>
        <p>¿Ya tienes cuenta? <a href="login_pantalla.php">Inicia sesión aquí</a></p>
    </section>
    <script src="$rutaJS"></script>
EOS;

// Si hay un error, mostrarlo en la pantalla
if (isset($_GET['error'])) {
    $contenidoPrincipal .= "<p style='color:red;'>⚠️ " . htmlspecialchars($_GET['error']) . "</p>";
}

// Incluir la plantilla para que se muestre correctamente
require_once __DIR__ . '/../comun/plantilla.php';
?>