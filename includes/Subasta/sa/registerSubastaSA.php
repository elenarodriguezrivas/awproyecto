<?php
require_once '../../Subasta/dao/SubastaDAO.php';
require_once '../../Subasta/model/Subasta.php';

class RegisterSubastaSA {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    /**
     * Registra una nueva subasta a partir de los datos recibidos.
     *
     * Se espera que $data contenga:
     * - idProducto
     * - fechaInicio
     * - fechaFin
     * - precioInicial
     *
     * @param array $data Datos de la subasta.
     * @return bool Resultado de la inserción.
     */
    public function registerSubasta($data) {
        // Aquí se pueden agregar validaciones, por ejemplo, verificar que las fechas sean correctas.
        $subasta = new Subasta(
            $data['idProducto'],
            $data['fechaInicio'],
            $data['fechaFin'],
            $data['precioInicial']
        );
        return $this->subastaDAO->create($subasta);
    }
}
?>
