<?php
require_once '../../Puja/dao/PujaDAO.php';

class EliminarPujaSA {
    private $pujaDAO;

    public function __construct(){
        $this->pujaDAO = new PujaDAO();
    }

    /**
     * Elimina una puja dado su identificador.
     *
     * @param int $idPuja Identificador de la puja a eliminar.
     * @return bool Resultado de la eliminación.
     */
    public function eliminarPuja($idPuja) {
        return $this->pujaDAO->delete($idPuja);
    }
}
?>
