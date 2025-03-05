<?php
$tituloPagina = "Registro de Usuario";

$contenidoPrincipal = <<<EOS
    <h2 class="form-title">Regístrate en MercaSwapp</h2>
    <form id="registerForm" action="../includes/controller/registerUsuarioController.php" method="POST" class="form">
        <div class="form-group">
            <label for="userid">User ID:</label>
            <input type="text" id="userid" name="userid" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required min="1" class="form-control"><br>
        </div>

        <div id="message" class="message"></div>

        <input type="hidden" name="action" value="register">
        <button type="submit" class="btn">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="login_pantalla.php">Inicia sesión aquí</a></p>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch("../includes/controller/registerUsuarioController.php", {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) });
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('message').innerHTML = data;
                document.getElementById('message').classList.add('success');
                document.getElementById('message').classList.remove('error');
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = 'Error al registrar el usuario: ' + error.message;
                document.getElementById('message').classList.add('error');
                document.getElementById('message').classList.remove('success');
            });
        });
    </script>

EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>