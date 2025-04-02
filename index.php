<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Inicio';

// Definir el contenido principal
$contenidoPrincipal = <<<EOS
        <div class = "bloque-titulo">
            <h2 style = "text-align: center">
                <strong> Transformando el mercado de segunda mano </strong>
            </h2>
        </div>
        <div class = "bloque-contenido">
            <p>MercaSwapp es una página web encargada del comercio de dispositivos y periféricos de segunda mano. 
                Navega por los productos disponibles. Añade los tuyos propios. Y oye, que si ya no lo quieres vender, puedes eliminarlo.
            </p>
            <div class="row justify-content-center">
                <div class = "row">
                    <p> En MercaSwapp reinventamos la compraventa de tecnología usada con:</p>
                </div>
                <div class = "row ">
                    <ul>
                        <li>🔄 Sistema de trueque eco-friendly</li>
                        <li>⚡ Subastas en tiempo real con pujas ocultas</li>
                        <li>🌱 Programa de compensación de huella digital</li>
                        <li>🔒 Garantía certificada de autenticidad</li>
                    </ul>
                </div>
                <div class = "row">
                    <p> El equipo de MercaSwapp está trabajando en estas nuevas funcionalidades. Sed pacientes 😊 </p>
                </div>
            </div>
                            
            <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental.</p>
            Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
            disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
        </div>
EOS;

require_once __DIR__ . "/comun/plantilla.php";
?>
