<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class CrearProductoSA {
    private ProductoDAO $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function registrarUsuario(Producto $producto): bool {
        return $this->productoDAO->agregarProducto($producto);
    }
    
}

?>
