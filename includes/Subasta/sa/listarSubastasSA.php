<?php
require_once __DIR__ . '/../dao/SubastaDAO.php';
require_once __DIR__ . '/../model/Subasta.php';

class listarSubastasSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    public function listarSubastas(): array {
        return $this->subastaDAO->listarSubastas();
    }

    public function listarSubastasUser($userid): array {
        return $this->subastaDAO->listarMisSubastas($userid);
    }
}
?>