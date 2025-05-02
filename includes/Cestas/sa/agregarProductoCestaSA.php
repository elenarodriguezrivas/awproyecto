<?php
require_once __DIR__ . '/../dao/cestaDAO.php';
require_once __DIR__ . '/../model/Cesta.php';

class agregarProductoCestaSA{

    private $cestaDAO;

    public function __construct() {
        $this->cestaDAO = new cestaDAO();
    }

    public function agregarProductoCesta($userId, $productoId){
        return $this->cestaDAO->agregarProductoACesta($userId, $productoId);
    }

}