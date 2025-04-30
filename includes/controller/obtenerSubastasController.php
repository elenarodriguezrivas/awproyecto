<?php
// Se requiere el DAO de subastas para obtener aquellas creadas por un usuario.
// Asegúrate de que en SubastaDAO se implemente el método findByUser($idUsuario)
require_once '../Subasta/dao/SubastaDAO.php';

class ObtenerSubastasUserController {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    /**
     * Obtiene todas las subastas creadas por un usuario.
     *
     * @param int $idUsuario Identificador del usuario.
     * @return array Lista de objetos Subasta.
     */
    public function obtenerSubastasPorUsuario($idUsuario) {
        return $this->subastaDAO->findByUser($idUsuario);
    }
}
?>
