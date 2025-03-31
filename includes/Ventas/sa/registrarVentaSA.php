<?php
require_once __DIR__ . '/../../Producto/dao/ProductoDAO.php';
require_once __DIR__ . '/../../Producto/model/Producto.php';

class registrarVentaSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function registrarVenta($id){
        return $this->productoDAO->venta($id);
    }

}
?>