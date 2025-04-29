<?php

require_once __DIR__.'/../includes/config.php';



$miembros = [
    ["nombre" => "Elena Rodríguez Rivas", "correo" => "elenro15@ucm.es", "imagen" => RUTA_IMGS."/elena.jpeg", "descripcion" => "Estudios: Ingeniería Informática y ADE, Hobbies: ir de compras"],
    ["nombre" => "María Victoria Magpali Pescador", "correo" => "mmagpali@ucm.es", "imagen" => RUTA_IMGS."/victoria.jpg", "descripcion" => "Estudios: Ingeniería Informática, Hobbies: voleibol"],
    ["nombre" => "Jun Daniel Wang", "correo" => "jundwang@ucm.es", "imagen" => RUTA_IMGS."/daniel.jpg", "descripcion" => "Estudios: Ingeniería Informática, Hobbies: dj"],
    ["nombre" => "Ya Jia Dai", "correo" => "yadai@ucm.es", "imagen" => RUTA_IMGS."/yajia.jpg", "descripcion" => "Estudios: Ingeniería Informática y ADE, Hobbies: probar restaurantes nuevos"],
    ["nombre" => "Alejandro Remiro Donaire", "correo" => "alejremi@ucm.es", "imagen" => RUTA_IMGS."/alejandro.jpg", "descripcion" => "Estudios: Ingeniería Informática, Hobbies: Tocar la guitarra y montar en moto"]
];

$tituloPagina = 'Contacto_Admin';

ob_start(); // Iniciar buffer de salida
?>

<center>
    <div class = "contacto-contenido">
        <div class="row">   <h3>¿Necesitas ayuda? No dudes en escribirnos</h3> </div>
        <div class="row justify-content-center">
            <?php foreach ($miembros as $miembro) : ?>
                <div class="custom-container">
                    <h4><?= htmlspecialchars($miembro['nombre']) ?></h4>
                    <img src="<?= htmlspecialchars($miembro['imagen']) ?>" alt="Imagen de <?= htmlspecialchars($miembro['nombre']) ?>" width="100" height="100">
                    <p><strong>Correo:</strong> <?= htmlspecialchars($miembro['correo']) ?></p>
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($miembro['descripcion']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
   </div> 

</center>

<?php
$contenidoPrincipal = ob_get_clean(); // Captura el contenido en el buffer
require_once __DIR__ . '/../comun/plantilla.php';
?>