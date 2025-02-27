<!DOCTYPE html>
<html lang="es"> <!--indicamos el lenguaje-->
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plataforma innovadora para compraventa sostenible de tecnología de segunda mano">
    <title>MercaSwapp - Tecnología Sostenible</title>
    <link id="estilo" rel="stylesheet" type="text/css" href="estilos.css?v=3"><!--Enlace a la hoja de estilos por defecto-->
    <link rel="stylesheet" media="print" href="impresora.css"> <!--Enlace a la hoja de estilos para imprimir la pagina-->
    <!--para probar la funcionalidad, cada vez que se quiera imprimir, la página saldrá con las letras en color berenjena-->
</head>

	<body>
		<div id="contenedor">

			<?php
				require("comun/cabecera.php");
				require("comun/barUnderHeader.php");
			?>

			<main>
				<article>
					<?= $contenidoPrincipal ?>
				</article>
			</main>

			<?php
				require("comun/pie.php");
			?>

		</div> <!-- Fin del contenedor -->

	</body>
</html>
