<?php
require_once __DIR__ . '/../dao/cestaDAO.php';
require_once __DIR__ . '/../model/Cesta.php';

class obtenerCestaSA{

    private $cestaDAO;

    public function __construct() {
        $this->cestaDAO = new cestaDAO();
    }

    public function obtenerCesta($userId){
        return $this->cestaDAO->obtenerCesta($userId);
    }

}