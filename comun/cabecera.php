<?php
session_start();
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
            <li><a href="/awproyecto/index.php">Inicio</a></li>
            <li><a href="/awproyecto/view/catalogo_pantalla.php">Productos</a></li>
            <li><a href="/awproyecto/view/micatalogo_pantalla.php">Mis Productos</a></li>
            <li><a href="/awproyecto/view/subasta_pantalla.php">Subastas</a></li>
            <li><a href="/awproyecto/view/perfil_pantalla.php">Perfil</a></li>
            <?php if (isset($_SESSION['login'])): ?>
                <li><a href="/awproyecto/view/logout_pantalla.php">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="/awproyecto/view/login_pantalla.php">Login</a></li>
                <li><a href="/awproyecto/view/register_pantalla.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>