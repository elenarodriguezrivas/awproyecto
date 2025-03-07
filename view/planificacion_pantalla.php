<?php
$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Planificación del proyecto</h2>
        <p class="diapositivas-ucm"> <em>El trabajo en grupo requiere esfuerzo de todos los miembros del equipo. En las prácticas y en el proyecto 
            final todos los miembros del equipo evalúan el trabajo hecho por sus compañeros. El profesor siempre puede evaluar de forma 
            individual los conocimientos de cada miembro del equipo</em></p>
        <h3>Entregas a realizar</h3>
        <p class="descripcion-breve">En la planificación interna del proyecto, se tuvo en cuentas las fechas de entrega propuestas por el 
            profesor de la asignatura <em>Humberto Javier</em>. Se muestran a continuación todas ellas, incluidas las fechas de los ejercicios en pareja.</p>
        <planimg><img src="/awproyecto/comun/img/fechas_planificacion.png" alt="fechas" ></planimg>
        <h3>Herramientas utilizadas para la elaboración del proyecto</h3>
        <p class="descripcion-breve">Se va a hacer uso de herramientas como <em>GitHub Desktop</em> para agilizar el desarrollo de las prácticas y poder hacer un registro del control de cambios...</p>
        <h3>Diagrama de Gantt</h3>
        <p>Se hace uso del siguiente diagrama de Gantt como herramienta de gestión de proyectos</p>
        <planimg><img src="/awproyecto/comun/img/ganttd.png" alt="gantt"> </planimg>
        <p>En este caso, las entregas no se solapan porque primero terminamos una y empezamos la siguiente. La entrega 2 depende de la terminación de la entrega 1. </p>
    </section>
EOS;

// Incluir la plantilla común
require_once __DIR__ . '/../comun/plantilla.php';
?>
