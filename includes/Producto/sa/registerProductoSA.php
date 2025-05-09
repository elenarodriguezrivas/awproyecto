<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class RegisterProductoSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function agregarProducto(Producto $producto): bool {
        return $this->productoDAO->agregarProducto($producto);
    }
    
    public function getIdProducto(Producto $producto): int{
        return $this->productoDAO->obtenerUltimoIdProducto();
    }
}

?>
