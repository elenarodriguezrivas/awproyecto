<?php
require_once __DIR__ . '/../dao/cestaDAO.php';
require_once __DIR__ . '/../model/Cesta.php';

class borrarProductoCestaSA{

    private $cestaDAO;

    public function __construct() {
        $this->cestaDAO = new cestaDAO();
    }

    public function borrarProductoCesta($userId, $productoId){
        return $this->cestaDAO->borrarProductoCesta($userId, $productoId);
    }

}