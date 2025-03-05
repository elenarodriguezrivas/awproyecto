<?php
$tituloPagina = 'Inicio';

// Definir el contenido principal
$contenidoPrincipal = <<<EOS
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
                        
        <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental.</p>
        Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
        disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>

        <div class="botones">
            <a href="./view/login_pantalla.php" class="boton">Iniciar Sesión</a>
            <a href="./view/register_pantalla.php" class="boton">Registrarse</a>
            <a href="./view/catalogo_pantalla.php" class="boton">Ver Catálogo</a>
        </div>
    </section>
EOS;

require_once __DIR__ . "/comun/plantilla.php";
?>
