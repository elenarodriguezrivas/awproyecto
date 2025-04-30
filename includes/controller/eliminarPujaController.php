<?php
require_once '../Puja/sa/eliminarPujaSA.php';

class EliminarPujaController {
    private $eliminarPujaSA;

    public function __construct() {
        $this->eliminarPujaSA = new EliminarPujaSA();
    }

    /**
     * Elimina una puja dado su identificador.
     *
     * @param int $idPuja Identificador de la puja a eliminar.
     * @return bool Resultado de la operación.
     */
    public function eliminarPuja($idPuja) {
        return $this->eliminarPujaSA->eliminarPuja($idPuja);
    }
}
?>
