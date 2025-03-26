<?php

require_once __DIR__.'/../includes/config.php';

$miembros = [
    ["nombre" => "Elena Rodríguez Rivas", "correo" => "elenro15@ucm.es", "imagen" => "/../comun/img/elena.jpeg", "descripcion" => "Estudios: Ingeniería Informática y ADE, Hobbies: ir de compras"],
    ["nombre" => "María Victoria Magpali Pescador", "correo" => "mmagpali@ucm.es", "imagen" => "/../comun/img/victoria.jpg", "descripcion" => "Estudios: Ingeniería Informática, Hobbies: voleibol"],
    ["nombre" => "Jun Daniel Wang", "correo" => "jundwang@ucm.es", "imagen" => "/../comun/img/daniel.jpg", "descripcion" => "Estudios: Ingeniería Informática, Hobbies: dj"],
    ["nombre" => "Ya Jia Dai", "correo" => "yadai@ucm.es", "imagen" => "/../comun/img/yajia.jpg", "descripcion" => "Estudios: Ingeniería Informática y ADE, Hobbies: probar restaurantes nuevos"],
    ["nombre" => "Alejandro Remiro Donaire", "correo" => "alejremi@ucm.es", "imagen" => "/../comun/img/alejandro.jpg", "descripcion" => "Estudios: Ingeniería Informática, Hobbies: Tocar la guitarra y montar en moto"]
];

$tituloPagina = 'Contacto_Admin';

ob_start(); // Iniciar buffer de salida
?>

<center>
    <table border="1">
        <tr><th colspan="6"><h2>¿Necesitas ayuda? No dudes en escribirnos</h2></th></tr>
        <tr>
            <th>Detalles</th>
            <?php foreach ($miembros as $miembro) : ?>
                <th><?= htmlspecialchars($miembro['nombre']) ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <th>Foto</th>
            <?php foreach ($miembros as $miembro) : ?>
                <td align="center"><img src="<?= htmlspecialchars($miembro['imagen']) ?>" width="100" height="100"></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <th>Correo</th>
            <?php foreach ($miembros as $miembro) : ?>
                <td align="center"><?= htmlspecialchars($miembro['correo']) ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <th>Descripción</th>
            <?php foreach ($miembros as $miembro) : ?>
                <td align="center"><?= htmlspecialchars($miembro['descripcion']) ?></td>
            <?php endforeach; ?>
        </tr>
    </table>
</center>

<?php
$contenidoPrincipal = ob_get_clean(); // Captura el contenido en el buffer
require_once __DIR__ . '/../comun/plantilla.php';
