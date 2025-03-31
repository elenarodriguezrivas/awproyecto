<?php
require_once __DIR__ . '/../../Producto/dao/ProductoDAO.php';
require_once __DIR__ . '/../../Producto/model/Producto.php';
require_once __DIR__ . '/../dao/VentaDAO.php';

class registrarVentaSA {
    private $productoDAO;
    private $ventaDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
        $this->ventaDAO = new VentaDAO();
    }

    public function registrarVenta($idProducto, $idComprador){
        $idVendedor = $this->productoDAO->obtenerVendedorPorProductoId($idProducto);
        $venta = new Venta($idProducto, $idComprador, $idVendedor);
        $this->productoDAO->venta($idProducto);
        return $this->ventaDAO->registrarVenta($venta);
    }

}
?>