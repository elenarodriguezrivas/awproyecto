<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Inicio';
$rutaA1 = RUTA_IMGS . "/anuncio1.png";
$rutaA2 = RUTA_IMGS . "/anuncio2.png";
$rutaA3 = RUTA_IMGS . "/anuncio3.jpeg";
$rutaA4 = RUTA_IMGS . "/anuncio4.jpeg";

// Definir el contenido principal
$contenidoPrincipal = <<<EOS
    <div class = "bloque-contenido">
        <h2 style = "text-align: center">
            <strong> Transformando el mercado de segunda mano </strong>
        </h2>
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

        <div class = "bloque-anuncios d-none d-xl-block">
            <div class = "custom-container">
                <div class="row">
                    <div class="col-3">
                        <div class = "bloque-anuncios-titulo">
                            <strong>¡NVIDIA 5090 - Compra la nueva grafica de NVIDIA!</strong>
                        </div>
                        <img src="$rutaA1" class="img-fluid">
                    </div>
                    <div class="col-3">
                        <div class = "bloque-anuncios-titulo">
                            <strong>¡IPHONE 16 - El MEJOR del mercado actual!</strong>
                        </div>
                        <img src="$rutaA2"class="img-fluid">
                    </div>
                    <div class="col-3">
                        <div class = "bloque-anuncios-titulo">
                            <strong>¡NINTENDO SWITCH2 - Novedad de la temporada!</strong>
                        </div>
                        <img src="$rutaA3"class="img-fluid"> 
                    </div>
                    <div class="col-3">
                        <div class = "bloque-anuncios-titulo">
                            <strong>¡PLAY5 - Sigue arrasando!</strong>
                        </div>
                        <img src="$rutaA4"class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

EOS;

require_once __DIR__ . "/comun/plantilla.php";
?>
