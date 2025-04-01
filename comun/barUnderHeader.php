<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"> <a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" 
                aria-haspopup="true" aria-expanded="false">Catalogo de Productos</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= RUTA_APP ?>/view/catalogo_pantalla.php">Productos</a>
                    <a class="dropdown-item" href="<?= RUTA_APP ?>/view/micatalogo_pantalla.php">Mis Productos</a>
                </div>
            </li>
            <li class="nav-item"> <a class="nav-link" href="<?= RUTA_APP ?>/view/subasta_pantalla.php">Subasta</a></li>
            <li class="nav-item"> <a class="nav-link" href="<?= RUTA_APP ?>/view/perfil_pantalla.php">Perfil</a></li>
            <?php if (isset($_SESSION['login'])): ?> <!--Si hay una sesión iniciada se muestra la posibilidad de cerrar sesión-->
                <li class="nav-item"> <a class="nav-link" href="<?= RUTA_APP ?>/view/logout_pantalla.php">Cerrar sesión</a></li>
            <?php else: ?><!--Si no hay una sesión iniciada se muestra la posibilidad de login o inicio de sesión-->
                <li class="nav-item"> <a class="nav-link" href="<?= RUTA_APP ?>/view/login_pantalla.php">Login</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= RUTA_APP ?>/view/register_pantalla.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>