<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once __DIR__ . '/../model/Producto.php';

class listarProductosSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function listarProductos(): array {
        return $this->productoDAO->listarProductos();
    }

    public function listarProductosUser($userid): array {
        return $this->productoDAO->listarMisProductos($userid);
    }
}
?>