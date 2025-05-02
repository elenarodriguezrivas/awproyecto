<?php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Cesta.php';
require_once __DIR__ . '/../../Producto/dao/ProductoDAO.php';

class CestaDAO {

    private $db;
    private $productoDAO;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
        $this->productoDAO = new ProductoDAO(); // Instancia de ProductoDAO
    }

    public function obtenerCesta($userId) {
        $query = "SELECT productoId FROM Cestas WHERE userId = :userId"; 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();

        $productoIds = $stmt->fetchAll(PDO::FETCH_COLUMN); 

        if ($productoIds) {
            $productos = [];
            foreach ($productoIds as $productoId) {
                $producto = $this->productoDAO->obtenerProductoPorId($productoId); 
                if ($producto) {
                    $productos[] = $producto; 
                }
            }
            return new Cesta($userId, $productos); 
        }

        return null;
    }

    public function vaciarCesta($userId) {
        $query = "DELETE FROM Cestas WHERE userId = :userId"; // Elimina todas las filas asociadas al userId
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->rowCount() > 0; // Devuelve true si se eliminaron filas, false en caso contrario
    }

    public function borrarProductoCesta($userId, $productoId) {
        $query = "DELETE FROM Cestas WHERE userId = :userId AND productoId = :productoId"; // Elimina el producto específico de la cesta
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':productoId', $productoId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->rowCount() > 0;
    }
    
}
