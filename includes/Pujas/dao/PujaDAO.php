<?php
require_once '../../database/Connection.php';
require_once '../model/Puja.php';

class PujaDAO {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }

    public static function insertarPuja($idProducto, $idPujador, $precio) {
        $sql = "INSERT INTO Pujas (idProducto, idPujador, precio) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$idProducto, $idPujador, $precio]);
    }

    public static function eliminarPuja($idProducto, $idPujador, $precio) {
        $sql = "DELETE FROM Pujas WHERE idProducto = ? AND idPujador = ? AND precio = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$idProducto, $idPujador, $precio]);
    }

    public static function obtenerPujasUsuario($idPujador) {
        $sql = "SELECT * FROM Pujas WHERE idPujador = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idPujador]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
