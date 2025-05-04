<?php
require_once '../../database/Connection.php';
require_once '../model/subasta.php';

class SubastaDAO {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }

    public static function agregarSubasta(Subasta $subasta) {
        $sql = "INSERT INTO Subastas (idProducto, fechaSubasta) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idProducto, $fecha]);
    }


    public static function eliminarSubasta($idProducto) {
        $conn = DB::getInstance()->getBD();
        $sql = "DELETE FROM Subastas WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$idProducto]);
    }

    public static function obtenerSubastasPorPropietario($idPropietario) {
        $conn = DB::getInstance()->getBD();
        $sql = "SELECT s.*, p.* FROM Subastas s 
                JOIN Productos p ON s.idProducto = p.id 
                WHERE p.propietario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idPropietario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
