<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Subasta/dao/SubastaDAO.php';
require_once __DIR__.'/../Subasta/model/Subasta.php';

class FormularioModificarSubasta extends Formulario
{
    private $subasta;

    public function __construct($subastaId)
    { //CONSTRUCTORA 
        parent::__construct('formModificarSubasta');
        
        $subastaDAO = new SubastaDAO();
        $this->initialize(new Subasta(), $subastaId); // Inicializar la subasta
        $this->producerVerification($this->subasta); // Verificar la subasta
    }

    private function initialize(Subasta $subasta, string $subastaId, SubastaDAO $subastaDAO){ //inicialización
        $this->subasta = $subastaDAO->obtenerSubastaPorId($subastaId);
        
        if (!$this->subasta) {
            header("Location: catalogo_subasta.php?error=Subasta no encontrada");
            exit;
        }
    }

    private function producerVerification(Subasta $subasta){ //verificación del productor
        // Verificar que el usuario actual es el propietario de la subasta
        if ($this->subasta->getIdVendedor() !== $_SESSION['userid']) {
            header("Location: catalogo_subasta.php?error=No tienes permiso para modificar esta subasta");
            exit;
        }
    }

    protected function generaCamposFormulario()
    {
        // Obtener datos directamente de la subasta
        $id = $this->subasta->getId();
        $nombreSubasta = $this->subasta->getNombreSubasta();
        $descripcionSubasta = $this->subasta->getDescripcionSubasta();
        $precio_original = $this->subasta->getPrecio_original();
        $rutaImagen = $this->subasta->getRutaImagen();

        $html = <<<EOF
        <div class="form-group">
            <input type="hidden" name="id" value="$id">
            <label for="nombreSubasta">Nombre de la Subasta:</label>
            <input id="nombreSubasta" type="text" name="nombreSubasta" value="$nombreSubasta" required class="form-control">
        </div>
        <div class="form-group">
            <label for="descripcionSubasta">Descripción de la Subasta:</label>
            <input id="descripcionSubasta" type="text" name="descripcionSubasta" value="$descripcionSubasta" required class="form-control">
        </div>
        <div class="form-group">
            <label for="precio_original">Precio original de la subasta:</label>
            <input id="precio_original" type="number" step="0.01" name="precio_original" value="$precio_original" required class="form-control">
        </div>
    EOF;
        $html .= <<<EOF
            </select>
        </div>
        <div class="form-group">
            <label>Imagen actual:</label>
            <img src="../$rutaImagen" alt="Imagen actual" style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
        </div>
        <div class="form-group">
            <label for="imagenSubasta">Nueva imagen (opcional):</label>
            <input id="imagenSubasta" type="file" name="imagenSubasta" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-blue">Guardar Cambios</button>
            <button type="button" onclick="window.location.href='catalogo_subasta.php'" class="btn btn-secondary">Cancelar</button>
        </div>
        <div id="message" class="message"></div>
    EOF;
        return $html;
    }
}