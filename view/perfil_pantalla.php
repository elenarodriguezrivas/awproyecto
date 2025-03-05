<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php");
    exit;
}

$tituloPagina = 'Perfil de Usuario';

$contenidoPrincipal = <<<EOS
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="perfil">
        <h1>Perfil de Usuario</h1>
        <p class="perfil-item">Nombre: <span id="nombre" class="perfil-dato"></span></p>
        <p class="perfil-item">Apellidos: <span id="apellidos" class="perfil-dato"></span></p>
        <p class="perfil-item">Edad: <span id="edad" class="perfil-dato"></span></p>
        <p class="perfil-item">Correo: <span id="correo" class="perfil-dato"></span></p>
    </div>

    <script src="JS/perfilJS.js"></script>

EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>