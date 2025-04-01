<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php'; // Incluye la clase DB

/**
 * Formulario de login de usuario.
 */
class FormularioLogin extends Formulario
{
    /**
     * Construye el formulario.
     */
    public function __construct()
    {
        parent::__construct('loginForm', ['urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php']);
    }

    /**
     * Genera los campos del formulario.
     */
    protected function generaCamposFormulario()
    {

        $html = <<<EOF
        <div class="form-group">
            <label for="userid">Usuario:</label>
            <input id="userid" type="text" name="userid" required class="form-control">
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña:</label>
            <input id="contrasena" type="password" name="contrasena" required class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Iniciar Sesión</button>
        </div>
        EOF;
        return $html;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        /*$this->errores = [];

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

        // Si no hay errores, validar con la base de datos
        if (count($this->errores) === 0) {
            $db = DB::getInstance(); // Obtener la instancia de la base de datos
            $query = "SELECT * FROM usuarios WHERE userid = :userid";
            $params = [':userid' => $userid];
            $stmt = $db->query($query, $params);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['userid'] = $usuario['userid'];
                $_SESSION['nombre'] = $usuario['nombre'];
            } else {
                $this->errores[] = "El usuario o la contraseña no coinciden";
            }
        }*/
    }
}