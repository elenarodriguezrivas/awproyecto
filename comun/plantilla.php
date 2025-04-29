<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plataforma innovadora para compraventa sostenible de tecnología de segunda mano">
    <title>MercaSwapp - Tecnología Sostenible</title>
    <link rel="stylesheet" href="<?= RUTA_CSS ?>/bootstrap.css">
    <link rel="stylesheet" href="<?= RUTA_CSS ?>/estilos.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"> </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class ="container-fluid">
        <div class = "row">
            <div class = "col-12">
                <?php require_once __DIR__ . "/cabecera.php"; ?>
            </div>
        </div>
        <div class = "row">
            <div class = "col-12">
                <?php require_once __DIR__ . "/barUnderHeader.php"; ?>
            </div>
        </div>
        <div class = "row aling-items-center">
            <div class="col-12"> 
                <main> <?= $contenidoPrincipal ?? "Contenido no disponible." ?> </main> 
			</div>
        </div>
        <div class = "row">
            <div class = "col-12">
                <?php require_once __DIR__ . "/pie.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
