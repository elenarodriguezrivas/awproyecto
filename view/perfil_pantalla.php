<?php
require_once __DIR__ . '/../controller/obtenerPerfilController.php';

$tituloPagina = 'Perfil';

// Evitar que la vista se cargue si no hay usuario
if (!$user) {
    $contenidoPrincipal = "<p>Error: No se pudo cargar el perfil.</p>";
} else {
    $contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Mi Perfil</h2>
        <div class="destacado">
            <ul>
                <div class="destacado">
                    <img src="$imagenPerfil" alt="Foto de perfil" width="150" height="150">
                    <p> <label for="nombre">Nombre: {$user['nombre']}</label> </p>
                    <p> <label for="1rApellido">1r Apellido: {$user['apellidos']}</label></p>
                    <p> <label for="Edad">Edad: {$user['edad']}</label> </p>
                    <p> <label for="Correo">Correo: {$correoPixelado}</label> </p> 
                    <p> <label for="Saldo">Saldo: {$user['saldo']} €</label> </p> 
                    <p> <a href="modificarperfil_pantalla.php"><button type="button">Cambiar Datos</button></a> </p>

                    <p class="descripcion-breve"><em>* : Opcional </em></p>
                </div>
            </ul>
        </div>
                            
        <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
        Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
        disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
EOS;
}

require_once __DIR__ . '/../comun/plantilla.php';
?>
