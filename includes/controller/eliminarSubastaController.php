<?php
require_once '../Subasta/sa/eliminarSubastaSA.php';

class EliminarSubastaController {
    private $eliminarSubastaSA;

    public function __construct() {
        $this->eliminarSubastaSA = new EliminarSubastaSA();
    }

    /**
     * Elimina una subasta dado su identificador.
     *
     * @param int $idSubasta Identificador de la subasta a eliminar.
     * @return bool Resultado de la operación.
     */
    public function eliminarSubasta($idSubasta) {
        return $this->eliminarSubastaSA->eliminarSubasta($idSubasta);
    }
}
?>
