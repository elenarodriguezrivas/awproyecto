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
            <p><strong>MercaSwapp</strong> es una página web encargada del comercio de dispositivos y periféricos de segunda mano. 
                Navega por los productos disponibles. Añade los tuyos propios. Y oye, que si ya no lo quieres vender, puedes eliminarlo.
            </p>
            <p> En MercaSwapp <strong>reinventamos</strong> la compraventa de tecnología usada con:</p>
            <ul class = "lista-centrada">	
                <li>♻️ <strong>Intercambio de productos entre usuarios</strong></li>
                <li>💰 <strong>Sistema de subastas dinámicas</strong></li>
                <li>🌍 <strong>Compromiso con la sostenibilidad</strong></li>
                <li>🔒 <strong>Seguridad y confianza en cada transacción</strong></li>
            </ul>
            <p> El equipo de MercaSwapp está trabajando en estas nuevas funcionalidades. Sed pacientes 😊 </p>
           
            <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental.</p>
            Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
            disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
        </div>
EOS;

require_once __DIR__ . "/comun/plantilla.php";
?>
