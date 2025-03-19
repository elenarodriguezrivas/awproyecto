<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function mostrarSaludo() {
    if (isset($_SESSION['login'])) {
        echo "<div class='saludo'>Bienvenido, ". $_SESSION['nombre'] .". <a href='/awproyecto/view/logout_pantalla.php'>Cerrar sesión</a></div>";
    } else {
        echo "<div class='saludo'>Usuario desconocido. <a href='/awproyecto/view/login_pantalla.php'>Login</a></div>";
    }
}
?>

<header>
    <h1>MercaSwapp</h1>
    <p class="tagline">Tecnología Circular • Subastas Dinámicas • Trueque Inteligente</p>
    <img src="/awproyecto/comun/img/logo-mercaswapp.png" alt="Logo MercaSwapp" class="logo">
    <nav id="barUnderHeader">
        <ul class="nav-links">
        </ul>
    </nav>
</header>