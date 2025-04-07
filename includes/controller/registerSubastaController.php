<?php
require_once '../Subasta/sa/registerSubastaSA.php';

class RegisterSubastaController {
    private $registerSubastaSA;

    public function __construct() {
        $this->registerSubastaSA = new RegisterSubastaSA();
    }

    /**
     * Registra una nueva subasta utilizando los datos proporcionados.
     *
     * Se espera que $data contenga los siguientes campos:
     * - idProducto
     * - fechaInicio
     * - fechaFin
     * - precioInicial
     *
     * @param array $data Datos de la subasta.
     * @return bool Resultado de la operación (true si se registró correctamente, false en caso contrario).
     */
    public function registerSubasta($data) {
        // Aquí se pueden incluir validaciones adicionales, por ejemplo, 
        // comprobar que las fechas sean válidas o que el precio inicial cumpla ciertos criterios.
        return $this->registerSubastaSA->registerSubasta($data);
    }
}
?>
