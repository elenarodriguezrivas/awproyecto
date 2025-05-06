<?php
require_once __DIR__ . '/../dao/SubastaDAO.php';
require_once __DIR__ . '/../model/Subasta.php';

class RegisterSubastaSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    public function agregarSubasta(Subasta $subasta): bool {
        return $this->subastaDAO->agregarSubasta($subasta);
    }
    
    public function getIdSubasta(Subasta $subasta): int{
        return $this->subastaDAO->obtenerUltimoIdSubasta();
    }
}

?>
