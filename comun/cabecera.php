<?php
session_start();
function mostrarSaludo() {
    if (isset($_SESSION['login'])) {
        echo "<div class='saludo'>Bienvenido, ". $_SESSION['nombre'] .". <a href='logout.php'>Cerrar sesión</a></div>";
    } else {
        echo "<div class='saludo'>Usuario desconocido. <a href='login.php'>Login</a></div>";
    }
}
?>

<header>
    <h1>MercaSwapp</h1>
    <p class="tagline">Tecnología Circular • Subastas Dinámicas • Trueque Inteligente</p>
    <img src="comun/img/logo-mercaswapp.png" alt="Logo MercaSwapp" class="logo">
</header>