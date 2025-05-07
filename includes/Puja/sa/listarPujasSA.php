<?php
require_once '../../Puja/dao/PujaDAO.php';

class ListarPujasSA {
    private $pujaDAO;

    public function __construct(){
        $this->pujaDAO = new PujaDAO();
    }

    /**
     * Lista todas las pujas asociadas a una subasta.
     *
     * @param int $idSubasta Identificador de la subasta.
     * @return array Lista de objetos Puja.
     */
    public function listarPujas($idSubasta) {
        return $this->pujaDAO->findBySubasta($idSubasta);
    }
}
?>
