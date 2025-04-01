<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php';

class FormularioRegistro extends Formulario
{
    public function __construct()
    {
        parent::__construct('formRegistro', ['urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $userid = $datos['userid'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $apellidos = $datos['apellidos'] ?? '';
        $email = $datos['email'] ?? '';
        $edad = $datos['edad'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores, 'errores-generales');
        $erroresCampos = self::generaErroresCampos(['userid', 'nombre', 'apellidos', 'email', 'edad', 'contrasena'], $this->errores, 'span', ['class' => 'error']);

        $html = <<<EOF
        <div class="form-group">
            <label for="userid">Usuario:</label>
            <input id="userid" type="text" name="userid" value="$userid" required class="form-control">
            {$erroresCampos['userid']}
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input id="contrasena" type="password" name="contrasena" required class="form-control">
            {$erroresCampos['contrasena']}
        </div>     
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="nombre" value="$nombre" required class="form-control">
            {$erroresCampos['nombre']}
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input id="apellidos" type="text" name="apellidos" value="$apellidos" required class="form-control">
            {$erroresCampos['apellidos']}
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input id="email" type="email" name="email" value="$email" required class="form-control">
            {$erroresCampos['email']}
        </div>
        <div class="form-group">
            <label for="edad">Edad:</label>
            <input id="edad" type="number" name="edad" value="$edad" required min="1" class="form-control">
            {$erroresCampos['edad']}
        </div>

        $htmlErroresGlobales
        <div class="form-group">
            <button type="submit" class="btn">Registrarse</button>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        // Validar usuario
        $userid = trim($datos['userid'] ?? '');
        $userid = filter_var($userid, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$userid || empty($userid)) {
            $this->errores['userid'] = 'El nombre de usuario no puede estar vacío';
        }

        // Validar contraseña
        $contrasena = trim($datos['contrasena'] ?? '');
        if (!$contrasena || empty($contrasena)) {
            $this->errores['contrasena'] = 'La contraseña no puede estar vacía';
        }

        // Validar nombre
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$nombre || empty($nombre)) {
            $this->errores['nombre'] = 'El nombre no puede estar vacío';
        }

        // Validar apellidos
        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$apellidos || empty($apellidos)) {
            $this->errores['apellidos'] = 'Los apellidos no pueden estar vacíos';
        }

        // Validar correo electrónico
        $email = trim($datos['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'El correo electrónico no es válido';
        }

        // Validar edad
        $edad = trim($datos['edad'] ?? '');
        if (!is_numeric($edad) || $edad < 1) {
            $this->errores['edad'] = 'La edad debe ser un número mayor a 0';
        }

        // Si no hay errores, insertar en la base de datos
        if (count($this->errores) === 0) {
            $db = DB::getInstance(); // Obtener la instancia de la base de datos
            $query = "INSERT INTO usuarios (userid, nombre, apellidos, email, edad, contrasena) VALUES (:userid, :nombre, :apellidos, :email, :edad, :contrasena)";
            $params = [
                ':userid' => $userid,
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':email' => $email,
                ':edad' => $edad,
                ':contrasena' => password_hash($contrasena, PASSWORD_DEFAULT)
            ];

            try {
                $db->query($query, $params);

                // Iniciar sesión automáticamente después del registro
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['userid'] = $userid;
                $_SESSION['nombre'] = $nombre;

                header("Location: perfil_pantalla.php");
                exit;
            } catch (Exception $e) {
                $this->errores[] = "El usuario ya existe o hubo un error al registrarse.";
            }
        }
    }
}