<?php
require_once '../../Subasta/dao/subastaDAO.php';
require_once '../../Subasta/model/subasta.php';

class RegisterSubastaSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    public function agregarSubasta(Subasta $subasta): bool {
        return $this->subastaDAO->agregarSubasta($subasta);
    }
?>
