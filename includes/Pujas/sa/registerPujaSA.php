<?php
require_once '../../Puja/dao/PujaDAO.php';
require_once '../../Puja/model/Puja.php';

class RegisterPujaSA {
    private $pujaDAO;

    public function __construct() {
        $this->pujaDAO = new PujaDAO();
    }

    /**
     * Registra una nueva puja a partir de los datos recibidos.
     *
     * Se espera que $data contenga:
     * - idSubasta
     * - idUsuario
     * - cantidad
     * - fecha
     *
     * @param array $data Datos de la puja.
     * @return bool Resultado de la inserción.
     */
    public function registerPuja($data) {
        // Aquí se podrían incluir validaciones adicionales,
        // como verificar que la cantidad sea superior a la última puja, etc.
        $puja = new Puja(
            $data['idSubasta'], 
            $data['idUsuario'], 
            $data['cantidad'], 
            $data['fecha']
        );
        return $this->pujaDAO->create($puja);
    }
}
?>
