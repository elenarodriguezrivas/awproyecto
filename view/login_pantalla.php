<?php
session_start();
if (isset($_SESSION['userid'])) {
    header("Location: perfil_pantalla.php");
    exit;
}

// Definir el contenido principal que se mostrará en la plantilla
$contenidoPrincipal = <<<EOS
    <h2 class="form-title">Iniciar Sesión en MercaSwapp</h2>
    <form id="loginForm" action="../includes/controller/loginUsuarioController.php" method="POST" class="form">
        <div class="form-group">
            <label for="userid">Usuario:</label>
            <input type="text" id="userid" name="userid" required class="form-control"><br>
        </div>

        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required class="form-control"><br>
        </div>

        <div id="message" class="message"></div>

        <input type="hidden" name="action" value="login">
        <button type="submit" class="btn">Iniciar Sesión</button>
    </form>

    <p>¿No tienes cuenta? <a href="register_pantalla.php">Regístrate aquí</a></p>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch("../includes/controller/loginUsuarioController.php", {
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
                if (data.includes("Login exitoso")) {
                    window.location.href = "perfil_pantalla.php";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = 'Error al iniciar sesión: ' + error.message;
                document.getElementById('message').classList.add('error');
                document.getElementById('message').classList.remove('success');
            });
        });
    </script>

EOS;

// Si hay un error, mostrarlo en la pantalla
if (isset($_GET['error'])) {
    $contenidoPrincipal .= "<p style='color:red;'>⚠️ " . htmlspecialchars($_GET['error']) . "</p>";
}

// Incluir la plantilla para que se muestre correctamente
require_once __DIR__ . '/../comun/plantilla.php';
?>
