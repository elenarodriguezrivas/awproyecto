<?php
session_start();

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/formulario/FormularioModificarPerfil.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para modificar tu perfil.");
    exit;
}

$tituloPagina = 'Modificar Perfil';
$rutaJS = RUTA_JS . '/modificarPerfilJS.js';

// Crear instancia del formulario
$form = new FormularioModificarPerfil($_SESSION['userid']);
$htmlFormulario = $form->generaFormulario(); // Llamar a generaFormulario, no a gestiona

// Construir la página con el formulario
$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Modificar mi Perfil</h2>
        <div class="destacado perfil-form">
            $htmlFormulario
        </div>
    </section>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>