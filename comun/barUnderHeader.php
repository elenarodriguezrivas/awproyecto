<nav class="navbar navbar-expand-xl navbar-dark bg-dark">
    <a class="navbar-brand d-block d-sm-none" href="#">MercaSwapp</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item space-to-center-underheaderbar"></li>
            <li class="nav-item space-between-elements"> <a class="nav-link" href="<?= RUTA_APP ?>/index.php">Inicio</a></li>
            <li class="nav-item dropdown space-between-elements">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" 
                aria-haspopup="true" aria-expanded="false">Catalogo de Productos</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= RUTA_APP ?>/view/catalogo_pantalla.php">Productos</a>
                    <a class="dropdown-item" href="<?= RUTA_APP ?>/view/micatalogo_pantalla.php">Mis Productos</a>
                </div>
            </li>
            <li class="nav-item dropdown space-between-elements">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" 
                aria-haspopup="true" aria-expanded="false">Subastas & Pujas</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= RUTA_APP ?>/view/subasta_pantalla.php">Subastas</a>
                    <a class="dropdown-item" href="<?= RUTA_APP ?>/view/catalogo_subasta.php">Mis Subastas</a>
                </div>
            </li>
            <li class="nav-item space-between-elements"> <a class="nav-link" href="<?= RUTA_APP ?>/view/perfil_pantalla.php">Perfil</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['login'])): ?>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li class="nav-item space-between-elements"> 
                        <a class="nav-link btn btn-primary" href="<?= RUTA_APP ?>/view/administrador_pantalla.php">Crear Categoría</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item space-between-elements"> <a class="nav-link" href="<?= RUTA_APP ?>/view/cesta_pantalla.php">Cesta de Compra</a></li>
                <li class="nav-item space-between-elementsa"> <a class="nav-link" href="<?= RUTA_APP ?>/view/logout_pantalla.php">Cerrar sesión</a></li>
            <?php else: ?>
                <li class="nav-item space-between-elements"> <a class="nav-link" href="<?= RUTA_APP ?>/view/login_pantalla.php">Login</a></li>
                <li class="nav-item space-between-elements"> <a class="nav-link" href="<?= RUTA_APP ?>/view/register_pantalla.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>