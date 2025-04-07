<?php
// Se requiere el DAO de subastas para obtener una subasta que pertenezca a un usuario concreto.
// Asegúrate de que en SubastaDAO se implemente el método findByIdAndUser($idSubasta, $idUsuario)
require_once '../Subasta/dao/SubastaDAO.php';

class ObtenerSubastaUserController {
    private $subastaDAO;

    public function __construct() {
        $this->subastaDAO = new SubastaDAO();
    }

    /**
     * Obtiene una subasta concreta que pertenezca a un usuario.
     *
     * @param int $idSubasta Identificador de la subasta.
     * @param int $idUsuario Identificador del usuario propietario.
     * @return Subasta|null Objeto Subasta o null si no se encuentra.
     */
    public function obtenerSubastaPorUsuario($idSubasta, $idUsuario) {
        return $this->subastaDAO->findByIdAndUser($idSubasta, $idUsuario);
    }
}
?>
