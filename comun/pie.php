<footer>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-custom-height">
        <!-- Visible solo en pantallas sm o más grandes -->
        <div class = "row align-items-center w-100 h-100 d-none d-sm-flex">
            <div class = "col-6 text-center text-white-custom ">© 2025 MercaSwapp - Grupo 6</div>
            <div class = "col-6 text-center">
                <a class="footer-link" href="<?= RUTA_APP ?>/view/contacto_pantalla.php" >Nuestro equipo</a> | 
                <a class="footer-link" href="<?= RUTA_APP ?>/view/planificacion_pantalla.php">Nuestra planificacion</a>
            </div>
        </div>
        <!-- HACER TODO QUE SEA IGUAL QUE EL XS SOLO QUE SI NO ES XS LE MOSTRAREMOS UN PAR DE ICONOS -->
        <!-- Visible solo en pantallas xs -->
        <div class = "row align-items-center justify-content-center text-center w-100 h-100 d-block d-sm-none">
            <p> 
                <a class="footer-link" href="<?= RUTA_APP ?>/view/contacto_pantalla.php" >Nuestro equipo</a> | 
                <a class="footer-link" href="<?= RUTA_APP ?>/view/planificacion_pantalla.php">Nuestra planificacion</a> 
            </p>
            <strong>© 2025 MercaSwapp - Grupo 6</strong>
        </div>
    </nav>
</footer>