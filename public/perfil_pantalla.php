<?php

$tituloPagina = 'Perfil';
		
$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Mi Perfil</h2>
            <div class="destacado">
                <ul>
                    <div class="destacado">
                    <p> <label for="nombre">Nombre: que lo pille de bbdd</label> </p>
                    <p> <label for="1rApellido">1r Apellido: que lo pille de bbdd</label> 
                    <label for="2oApellido">2o Apellido*: que lo pille de bbdd</label> </p>
                    <p> <label for="Edad">Edad: que lo pille de bbdd</label> </p>
                    <p> <label for="Correo">Correo: que salga pixelado los primeros chars</label> </p> 
                    <p> <a href="modificarperfil_pantalla.php"><button type="button">Cambiar Datos</button></a> </p>

                    <p class="descripcion-breve"><em>* : Opcional </em></p>
                </ul>
            </div>
                            
            <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
            Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
            disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
EOS;

require("comun/plantilla.php");
?>