<?php
require_once '../../Subasta/dao/subastaDAO.php';

class ListarSubastasSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    /**
     * Lista todas las subastas registradas.
     *
     * @return array Lista de objetos Subasta.
     */
    public function listarSubastas() {
        return $this->subastaDAO->findAll();
    }
}
?>
