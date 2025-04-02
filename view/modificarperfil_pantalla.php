<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/Usuarios/sa/perfilSA.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para modificar tu perfil.");
    exit;
}

$tituloPagina = 'Modificar Perfil';

// Obtener datos del usuario actual
$perfilSA = new PerfilSA();
$usuario = $perfilSA->obtenerUsuarioPorId($_SESSION['userid']);

// Inicializar variables con datos del usuario
$userId = $usuario->getUserid();
$nombre = $usuario->getNombre();
$apellidos = $usuario->getApellidos();
$email = $usuario->getEmail();
$edad = $usuario->getEdad();

$rutaJS = RUTA_JS . '/modificarPerfilJS.js';

$contenidoPrincipal = <<<EOS
<section class="presentacion">
    <h2>Modificar mi Perfil</h2>
    <div class="perfil-form destacado">
        <form id="modificarPerfilForm" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="$nombre" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="$apellidos" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" value="$email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" value="$edad" min="1" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="contrasena">Nueva contraseña (dejar en blanco para mantener la actual):</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="confirmarContrasena">Confirmar nueva contraseña:</label>
                <input type="password" id="confirmarContrasena" name="confirmarContrasena" class="form-control">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-blue">Guardar cambios</button>
            </div>
        </form>
        <div id="message" class="message"></div>
    </div>
</section>
<script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>