<!--barra de navegación debajo del encabezado-->
<nav id="barUnderHeader">
<!--Dentro de estilos.css tenemos un formato específico para nav-links-->
    <ul class="nav-links">
        <div class="center">
            <li><a href="/awproyecto/index.php">Inicio</a></li>
            <li><a href="/awproyecto/view/catalogo_pantalla.php">Productos</a></li>
            <li><a href="/awproyecto/view/micatalogo_pantalla.php">Mis Productos</a></li>
            <li><a href="/awproyecto/view/subasta_pantalla.php">Subastas</a></li>
            <li><a href="/awproyecto/view/perfil_pantalla.php">Perfil</a></li>
        </div>
        <div class="right">
            <?php if (isset($_SESSION['login'])): ?> <!--Si hay una sesión iniciada se muestra la posibilidad de cerrar sesión-->
                <li><a href="/awproyecto/view/logout_pantalla.php">Cerrar sesión</a></li>
            <?php else: ?><!--Si no hay una sesión iniciada se muestra la posibilidad de login o inicio de sesión-->
                <li><a href="/awproyecto/view/login_pantalla.php">Login</a></li>
                <li><a href="/awproyecto/view/register_pantalla.php">Registrarse</a></li>
            <?php endif; ?>
        </div>
    </ul>
</nav>
