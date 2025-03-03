<?php
$tituloPagina = "Registro de Usuario";

$contenidoPrincipal = <<<EOS
    <h2>Regístrate en MercaSwapp</h2>
    <form id="registerForm" action="../includes/controller/registerUsuarioController.php" method="POST">
        <label for="userid">User ID:</label>
        <input type="text" id="userid" name="userid" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required min="1"><br>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="usuario">Usuario</option>
            <option value="admin">Administrador</option>
        </select><br>

        <input type="hidden" name="action" value="register">
        <button type="submit">Registrarse</button>
    </form>

    <div id="message"></div>

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
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = 'Error al registrar el usuario: ' + error.message;
            });
        });
    </script>

EOS;

require_once __DIR__ . "/../comun/plantilla.php";
?>