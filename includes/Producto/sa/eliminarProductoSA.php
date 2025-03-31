<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class eliminarProductoSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function eliminarProducto($idProducto, $idVendedor) {
        return $this->productoDAO->eliminarProducto($idProducto, $idVendedor);
    }
    
}

?>
