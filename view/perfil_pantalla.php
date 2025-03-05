<?php
<<<<<<< HEAD
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php");
    exit;
}

$tituloPagina = 'Perfil de Usuario';

$contenidoPrincipal = <<<EOS
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="perfil">
        <h1>Perfil de Usuario</h1>
        <p>Nombre: <span id="nombre"></span></p>
        <p>Apellidos: <span id="apellidos"></span></p>
        <p>Edad: <span id="edad"></span></p>
        <p>Correo: <span id="correo"></span></p>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../includes/controller/obtenerPerfilController.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#nombre').text(data.nombre);
                        $('#apellidos').text(data.apellidos);
                        $('#edad').text(data.edad);
                        $('#correo').text(data.correo);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al obtener el perfil:', textStatus, errorThrown);
                }
            });
        });
    </script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';