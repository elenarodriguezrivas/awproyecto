<?php
require_once '../../Subasta/dao/subastaDAO.php';

class listarSubastasSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    public function obtenerProductosSubastados() {
        return $this->subastaDAO->obtenerProductosEnSubasta();
    }
}
