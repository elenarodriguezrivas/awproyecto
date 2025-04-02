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
    <div class = "row">
        <div class = "col-md-4"> <h1>MercaSwapp</h1> </div>
        <div class = "col-md-5"> Tecnología Circular • Subastas Dinámicas • Trueque Inteligente </div> 
        <div class = "col-md-4"><img src="<?= RUTA_IMGS ?>/logo-mercaswapp.png" alt="Logo MercaSwapp" class="logo"> </div>
    </div>
</header>