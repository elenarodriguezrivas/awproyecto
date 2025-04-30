<?php
require_once '../../Subasta/dao/SubastaDAO.php';

class EliminarSubastaSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    /**
     * Elimina una subasta dado su identificador.
     *
     * @param int $idSubasta Identificador de la subasta a eliminar.
     * @return bool Resultado de la operación de eliminación.
     */
    public function eliminarSubasta($idSubasta) {
        return $this->subastaDAO->delete($idSubasta);
    }
}
?>
