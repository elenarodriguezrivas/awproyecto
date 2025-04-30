<?php
// Se requiere el DAO para poder filtrar pujas por usuario.
// Asegúrate de que en PujaDAO se implemente el método findByUser($idUsuario)
require_once '../Puja/dao/PujaDAO.php';

class ObtenerPujaUserController {
    private $pujaDAO;

    public function __construct() {
        $this->pujaDAO = new PujaDAO();
    }

    /**
     * Obtiene todas las pujas realizadas por un usuario.
     *
     * @param int $idUsuario Identificador del usuario.
     * @return array Lista de objetos Puja.
     */
    public function obtenerPujasPorUsuario($idUsuario) {
        return $this->pujaDAO->findByUser($idUsuario);
    }
}
?>
