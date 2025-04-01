<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php';

class FormularioRegistro extends Formulario
{
    public function __construct()
    {
        parent::__construct('registerForm', ['urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php']);
    }

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
            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="nombre" required class="form-control">
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input id="apellidos" type="text" name="apellidos" required class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input id="email" type="email" name="email" required class="form-control">
        </div>
        <div class="form-group">
            <label for="edad">Edad:</label>
            <input id="edad" type="number" name="edad" required min="1" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn">Registrarse</button>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
    }
}