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

// Crear instancia del formulario y llamar a initialize
$form = new FormularioModificarPerfil($_SESSION['userid']);
$form->initialize(); // Inicializar el formulario (carga los datos del usuario)
$htmlFormulario = $form->generaFormulario(); // Generar el HTML del formulario

// Construir la página con el formulario
$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Modificar mi Perfil</strong></h2>
        <div class="destacado perfil-form">
            $htmlFormulario
        </div>
    </div>
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>