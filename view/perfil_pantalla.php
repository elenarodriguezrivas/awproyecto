<?php

require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Perfil de Usuario';

$rutaJS = RUTA_JS . '/perfilJS.js';

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Bienvenido a tu perfil, <span id="nombre" class="perfil-dato"></span></strong></h2>
        <h5><strong>Apellidos</strong>: <span id="apellidos" class="perfil-dato"></span></h5>
        <h5><strong>Edad</strong>: <span id="edad" class="perfil-dato"></span></h5>
        <h5><strong>Correo</strong>: <span id="correo" class="perfil-dato"></span></h5>
        <a href="modificarperfil_pantalla.php"><button class ="btn">Modificar perfil</button></a>
    </div>
    <script src="$rutaJS"></script>

EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>