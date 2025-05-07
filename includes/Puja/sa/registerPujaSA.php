<?php
require_once __DIR__ . '/../dao/PujaDAO.php';
require_once __DIR__ . '/../model/Puja.php';

class RegisterPujaSA {
    private $pujaDAO;

    public function __construct() {
        $this->pujaDAO = new PujaDAO();
    }

    public function agregarPuja(Puja $puja): bool {
        return $this->pujaDAO->agregarPuja($puja);
    }
}

?>
