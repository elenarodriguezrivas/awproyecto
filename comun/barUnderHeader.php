<!--barra de navegación debajo del encabezado-->
<nav id="barUnderHeader">
<!--Dentro de estilos.css tenemos un formato específico para nav-links-->
    <ul class="nav-links">
        <div class="center">
            <li><a href="<?= RUTA_APP ?>/index.php">Inicio</a></li>
            <li><a href="<?= RUTA_APP ?>/view/catalogo_pantalla.php">Productos</a></li>
            <li><a href="<?= RUTA_APP ?>/view/micatalogo_pantalla.php">Mis Productos</a></li>
            <li><a href="<?= RUTA_APP ?>/view/catalogo_subasta.php">Subastas</a></li>
            <li><a href="<?= RUTA_APP ?>/view/subasta_pantalla.php">Mis Subastas</a></li>
            <li><a href="<?= RUTA_APP ?>/view/perfil_pantalla.php">Perfil</a></li>
        </div>
        <div class="right">
            <?php if (isset($_SESSION['login'])): ?> <!--Si hay una sesión iniciada se muestra la posibilidad de cerrar sesión-->
                <li><a href="<?= RUTA_APP ?>/view/logout_pantalla.php">Cerrar sesión</a></li>
            <?php else: ?><!--Si no hay una sesión iniciada se muestra la posibilidad de login o inicio de sesión-->
                <li><a href="<?= RUTA_APP ?>/view/login_pantalla.php">Login</a></li>
                <li><a href="<?= RUTA_APP ?>/view/register_pantalla.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>