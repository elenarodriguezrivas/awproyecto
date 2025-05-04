<?php
require_once __DIR__.'/../includes/config.php';

// Iniciar sesión para acceder al ID del usuario
session_start();

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
$mensajeAdicional = "";

// Si tenemos un usuario en sesión, mostramos un mensaje personalizado
if ($userId) {
    $mensajeAdicional = <<<HTML
    <p>Tu pedido ha sido procesado y recibirás un correo electrónico con los detalles.</p>
    <p>Puedes revisar el estado de tus compras en tu perfil de usuario.</p>
    HTML;
}

$tituloPagina = "Pago realizado correctamente";
$contenidoPrincipal = <<<HTML
<div class="container mt-5 text-center">
    <div class="alert alert-success p-5">
        <h1 class="display-4">✅ ¡Gracias por tu compra!</h1>
        <p class="lead">Tu pago se ha realizado con éxito.</p>
        $mensajeAdicional
    </div>
    
    <div class="mt-4">
        <a href="/awproyecto/index.php" class="btn btn-primary">Volver a la tienda</a>
        
        <!-- Botón adicional para ver las compras si hay usuario logueado -->
        <!--  ?php if (isset(\$_SESSION['userid'])): ?>
        <a href="/awproyecto/view/mis_compras.php" class="btn btn-outline-secondary ms-2">Ver mis compras</a>
        <?php endif; ?      -->
    </div>
</div>
HTML;

require_once __DIR__ . '/../comun/plantilla.php';
?>