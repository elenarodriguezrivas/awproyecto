

<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class obtenerProductoPorIdSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function obtenerProductoPorId(string $id): ?Producto {
        return $this->productoDAO->obtenerProductoPorId($id);
    }
    
}

?>
