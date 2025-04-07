<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Perfil de Usuario';

$rutaJS = RUTA_JS . '/perfilJS.js';

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Bienvenido a tu perfil, <span id="nombre" class="perfil-dato"></span></strong></h2>
        <p>Apellidos: <span id="apellidos" class="perfil-dato"></span></p>
        <p>Edad: <span id="edad" class="perfil-dato"></span></p>
        <p>Correo: <span id="correo" class="perfil-dato"></span></p>
        <a href="modificarperfil_pantalla.php"><button>Modificar perfil</button></a>
    </div>
    <script src="$rutaJS"></script>

EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>