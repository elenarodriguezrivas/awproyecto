<?php
require_once __DIR__ . '/../dao/subastaDAO.php';
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

    public function obtenerSubastaPorId(int $idSubasta) {
        return $this->subastaDAO->obtenerSubastaPorId($idSubasta);
    }

    public function actualizarPrecioActual(int $idSubasta, float $nuevoPrecio){
        return $this->subastaDAO->actualizarPrecioActual($idSubasta, $nuevoPrecio);
    }
}

?>
