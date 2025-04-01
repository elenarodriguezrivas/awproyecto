<?php

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/formulario/FormularioLogin.php';

// Si el usuario ya está autenticado, redirigir al perfil
if (isset($_SESSION['userid'])) {
    header("Location: perfil_pantalla.php");
    exit;
}

$rutaJS = RUTA_JS . '/loginJS.js';

// Crear una instancia del formulario de login
$formularioLogin = new FormularioLogin();
$htmlFormulario = $formularioLogin->gestiona();

// Definir el contenido principal que se mostrará en la plantilla
$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2 class="form-title">Iniciar Sesión en MercaSwapp</h2>
        <div class="destacado">
            $htmlFormulario
            <div id="message" class="message"></div>
        </div>
        <p>¿No tienes cuenta? <a href="register_pantalla.php">Regístrate aquí</a></p>
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