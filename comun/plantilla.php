<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plataforma innovadora para compraventa sostenible de tecnología de segunda mano">
    <title>MercaSwapp - Tecnología Sostenible</title>
    <link id="estilo" rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilos.css?v=3">
    <link rel="stylesheet" media="print" href="<?= RUTA_CSS ?>/estilos.css">
</head>

<body>
    <div id="contenedor">
        <?php
            require_once __DIR__ . "/cabecera.php";
            require_once __DIR__ . "/barUnderHeader.php";
        ?>

	<main>
	  	<article>
		  <?= $contenidoPrincipal ?? "Contenido no disponible." ?>
		</article>
	</main>

        <?php
            require_once __DIR__ . "/pie.php";
        ?>
    </div>
</body>
</html>
