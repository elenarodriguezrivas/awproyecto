<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Usuarios/dao/UsuarioDAO.php';
require_once __DIR__.'/../Usuarios/model/Usuario.php';

class FormularioModificarPerfil extends Formulario
{
    private $usuario;

    public function __construct($userId)
    { //CONSTRUCTORA 
        parent::__construct('formModificarPerfil');
        
        $usuarioDAO = new UsuarioDAO();
        $this->initialize($usuario, $userId, $usuarioDAO); // Inicializar el usuario
    }

    private function initialize(Usuario $usuario, string $userId, UsuarioDAO $usuarioDAO)
    {
        $this->usuario = $usuarioDAO->obtenerUsuario($userId);
        
        if (!$this->usuario) {
            header("Location: login_pantalla.php?error=Usuario no encontrado");
            exit;
        }
    }

    // Implementación correcta sin parámetro $datos
    protected function generaCamposFormulario()
    {
        // Obtener datos directamente del usuario
        $nombre = $this->usuario->getNombre();
        $apellidos = $this->usuario->getApellidos();
        $email = $this->usuario->getEmail();
        $edad = $this->usuario->getEdad();

        $html = <<<EOF
        <div class="form-group">
            <input type="hidden" name="userid" value="{$this->usuario->getUserid()}">
            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="nombre" value="$nombre" required class="form-control">
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input id="apellidos" type="text" name="apellidos" value="$apellidos" required class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input id="email" type="email" name="email" value="$email" required class="form-control">
        </div>
        <div class="form-group">
            <label for="edad">Edad:</label>
            <input id="edad" type="number" name="edad" value="$edad" required min="1" class="form-control">
        </div>
        <div class="form-group">
            <label for="contrasena">Nueva Contraseña (dejar en blanco para mantener la actual):</label>
            <input id="contrasena" type="password" name="contrasena" class="form-control">
        </div>
        <div class="form-group">
            <label for="confirmarContrasena">Confirmar Nueva Contraseña:</label>
            <input id="confirmarContrasena" type="password" name="confirmarContrasena" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-blue">Guardar Cambios</button>
            <a href="perfil_pantalla.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <div id="message" class="message"></div>
        EOF;
        return $html;
    }
}