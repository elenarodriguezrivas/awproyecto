<?php

$tituloPagina = 'Portada';
        
$contenidoPrincipal=<<<EOS
   <section class="presentacion">
        <h2>Transformando el mercado de segunda mano</h2>
        <div class="destacado">
            <p>En MercaSwapp reinventamos la compraventa de tecnología usada con:</p>
            <ul>
                <li>🔄 Sistema de trueque eco-friendly</li>
                <li>⚡ Subastas en tiempo real con pujas ocultas</li>
                <li>🌱 Programa de compensación de huella digital</li>
                <li>🔒 Garantía certificada de autenticidad</li>
            </ul>
        </div>
                        
        <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
        Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
        disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
EOS;

require("comun/plantilla.php");
?>

<html lang="es">
<body>
    <h1>Registrar Usuario</h1>
    <div id="registro">
        <form action="./includes/controller/registrarUsuario-controller.php" method="post">
            <label for="userid">User ID:</label>
            <input type="text" id="userid" name="userid" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required><br>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required><br>

            <label for="rol">Rol:</label>
            <input type="text" id="rol" name="rol" required><br>

            <input type="submit" value="Registrar">
        </form>
    </div>
</body>
</html>