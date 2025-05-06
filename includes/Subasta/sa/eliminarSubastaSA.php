<?php
require_once __DIR__ . '/../dao/SubastaDAO.php';
require_once __DIR__ . '/../model/Subasta.php';

class eliminarSubastaSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    public function eliminarSubasta($idSubasta, $idVendedor) {
        return $this->subastaDAO->eliminarSubasta($idSubasta, $idVendedor);
    }
    
}

?>
