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
    <!--none(no muestra), block(muestra) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-none d-sm-block">
        <div class = "row align-items-center w-100 h-100 d-none d-sm-flex">
            <div class = "col-sm-4 col-lg-2 text-left d-none d-sm-block text-white-custom">
                <h2>MercaSwapp</h2>
            </div>
            <!-- Texto para pantallas lg -->
            <div class="col-lg-8 text-center d-none d-xl-block text-white-custom">
                <h3>Tecnología Circular • Subastas Dinámicas • Trueque Inteligente</h3>
            </div>
            <div class = "col-lg-2 text-right d-none d-xl-block" >
                <img src="<?= RUTA_IMGS ?>/logo-mercaswapp.png" alt="Logo MercaSwapp"  class="img-fluid" width="30%"> 
            </div>
            <!-- Texto para pantallas sm-md-->
            <div class="col-sm-8 text-right d-none d-sm-block d-xl-none text-white-custom">
                <h2>Tecnología Circular</h2>
            </div>
        </div>
    </nav>
</header>