<?php
session_start();
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/Usuarios/sa/perfilSA.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para modificar tu perfil.");
    exit;
}

$contenidoPrincipal=<<<EOS
    <div class="bloque-titulo">
        <h2><strong>Modificar mi Perfil</strong></h2>
    </div>
    <div class="bloque-contenido">
        <form method="post" action="">
            <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="$nombre"><br><br>
            <label for="apellidos">1r Apellido:</label>
                <input type="text" id="apellido1" name="apellidos" value="$apellido1"><br><br>
            <label for="apellidos">2o Apellido:</label>
                <input type="text" id="apellido2" name="apellidos" value="$apellido2"><br><br>
            <label for="edad">Edad:</label>
                <input type="text" id="edad" name="edad" value="$edad"><br><br>
            <label for="correo">Correo:</label>
                <input type="text" id="correo" name="correo" value="$correo"><br><br>
            <label for="contra">Contraseña:</label>
                <input type="text" id="contra" name="contra" value="$contra"><br><br>
            <button type="submit">Guardar</button>
        </form>
        <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
        Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
        disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </div>                
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>