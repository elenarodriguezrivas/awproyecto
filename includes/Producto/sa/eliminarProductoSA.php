<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class eliminarProductoSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function eliminarProducto(string $id): string {
        return $this->productoDAO->eliminarProducto($id) ? "Producto eliminado." : "Error al eliminar producto.";
    }
    
}

?>
