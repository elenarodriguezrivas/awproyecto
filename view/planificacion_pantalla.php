<?php
require_once __DIR__.'/../includes/config.php';

$ruta_img1 = RUTA_IMGS . '/fechas_planificacion.png';
$ruta_img2 = RUTA_IMGS . '/ganttd.png';

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2><strong>Planificación del proyecto</strong></h2>
        <p class="descripcion-breve">El proyecto se ha realizado en grupo, por lo que se ha tenido que planificar el trabajo a realizar. 
            A continuación se muestra la planificación del proyecto y las herramientas utilizadas para su desarrollo.</p>
        <h3><strong>Entregas a realizar</strong></h3>
        <p class="descripcion-breve">En la planificación interna del proyecto, se tuvo en cuentas las fechas de entrega propuestas por el 
        profesor de la asignatura <em>Humberto Javier</em>. Se muestran a continuación todas ellas, incluidas las fechas de los ejercicios en pareja.</p>
        <div class = "row align-items-center justify-content-center">
            <div class="col-12">
                <img src="$ruta_img1" alt="fechas" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
        </div>
        <h3><strong>Diagrama de Gantt</strong></h3>
         <div class = "row align-items-center justify-content-center">
            <div class="col-12">
                <img src="$ruta_img2" alt="gantt" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
        </div>
        <p>En este caso, las entregas no se solapan porque primero terminamos una y empezamos la siguiente. La entrega 2 depende de la terminación de la entrega 1. </p>
    </div>
EOS;

    // Incluir la plantilla común
    require_once __DIR__ . '/../comun/plantilla.php';
?>