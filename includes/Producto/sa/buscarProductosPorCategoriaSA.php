<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class buscarProductosPorCategoriaSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function buscarProductosPorCategoria(string $categoria): array{
        return $this->productoDAO->buscarProductosPorCategoria($categoria);
    }
    
}

?>