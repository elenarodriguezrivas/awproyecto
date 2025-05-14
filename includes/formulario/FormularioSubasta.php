<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php';
require_once __DIR__.'/../Subasta/model/Subasta.php'; 
require_once __DIR__.'/../Subasta/sa/registerSubastaSA.php';
require_once __DIR__.'/../Subasta/dao/SubastaDAO.php';

class FormularioSubasta extends Formulario
{
    public function __construct()
    {
        parent::__construct('subastaForm', [
            'urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php'
        ]);
    }

    protected function generaCamposFormulario()
{

    // Inicio del formulario
    $html = <<<EOF
    <div class="form-group">
        <label for="nombreSubasta">Nombre de la Subasta:</label>
        <input id="nombreSubasta" type="text" name="nombreSubasta" required class="form-control">
    </div>
    <div class="form-group">
        <label for="descripcionSubasta">Descripción de la Subasta:</label>
        <input id="descripcionSubasta" type="text" name="descripcionSubasta" required class="form-control">
    </div>
    <div class="form-group">
        <label for="precio_original">Precio original de la subasta:</label>
        <input id="precio_original" type="number" step="0.01" name="precio_original" required class="form-control">
    </div>

    <div class="form-group">
        <label for="imagenSubasta">Imagen del Producto a Subastar:</label>
        <input id="imagenSubasta" type="file" name="imagenSubasta" required class="form-control">
    </div>
    <div class="form-group">
            <label for="fechaSubasta">Fecha de subasta:</label>
            <input type="date" name="fechaSubasta" id="fechaSubasta">
    </div>
    <div class="form-group">
            <label for="horaSubasta">Hora subasta:</label>
            <input type="time" name="horaSubasta" id="horaSubasta">
    </div>

    <div class="form-group">
        <button type="submit" class="btn">Registrar Subasta</button>
    </div>

EOF;

    return $html;
}

    protected function procesaFormulario(&$datos)
    {
    }
}
