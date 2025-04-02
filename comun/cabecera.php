<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    function mostrarSaludo() {
        if (isset($_SESSION['login'])) {
            echo "<div class='saludo'>Bienvenido, ". $_SESSION['nombre'] .". <a href='<?= RUTA_APP ?>/view/logout_pantalla.php'>Cerrar sesión</a></div>";
        } else {
            echo "<div class='saludo'>Usuario desconocido. <a href='<?= RUTA_APP ?>/view/login_pantalla.php'>Login</a></div>";
        }
    }
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "row align-items-center w-100 h-100 d-none d-sm-flex">
            <div class = "col-sm-6 col-md-2 text-left d-none d-sm-block"><h1>MercaSwapp </h1></div>
            <!--EN DISPOSITIVOS MOVILES DESAPARECEN-->
            <!--none(no muestra), block(muestra) -->
            <!-- Texto para pantallas mayores a md -->
            <div class="col-md-8 text-center d-none d-lg-block">
                <h3>Tecnología Circular • Subastas Dinámicas • Trueque Inteligente</h3>
            </div>
            <!-- Texto para pantallas sm-md-->
            <div class="col-md-8 text-center d-none d-sm-block d-lg-none">
                <h3>Tecnología Circular</h3>
            </div>
            <div class = "col-sm-6 col-md-2 text-right d-none d-md-block" ><img src="<?= RUTA_IMGS ?>/logo-mercaswapp.png" alt="Logo MercaSwapp"  class="img-fluid" width="30%"> </div>
        </div>
    </nav>
</header>