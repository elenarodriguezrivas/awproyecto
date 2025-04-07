<?php
require_once '../Puja/sa/registerPujaSA.php';

class RegisterPujaController {
    private $registerPujaSA;

    public function __construct() {
        $this->registerPujaSA = new RegisterPujaSA();
    }

    /**
     * Registra una nueva puja a partir de los datos proporcionados.
     *
     * Se espera que $data contenga:
     * - idSubasta
     * - idUsuario
     * - cantidad
     * - fecha
     *
     * @param array $data Datos de la puja.
     * @return bool Resultado de la operación.
     */
    public function registerPuja($data) {
        return $this->registerPujaSA->registerPuja($data);
    }
}
?>
