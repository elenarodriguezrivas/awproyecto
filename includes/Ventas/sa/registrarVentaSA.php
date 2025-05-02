<?php
require_once __DIR__ . '/../../Producto/dao/ProductoDAO.php';
require_once __DIR__ . '/../dao/VentaDAO.php';

/**
 * Clase para registrar una venta de un producto. Especificamente una unica operacion 
 * Obtiene el vendedor del producto (obtenerVendedorPorProductoId).
 * Marca el producto como vendido (venta en ProductoDAO).
 * Registra la venta en la tabla de ventas (registrarVenta en VentaDAO).
 */
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
        if(!$this->productoDAO->venta($idProducto)) return false;
        if(!$this->ventaDAO->registrarVenta($venta)) return false;
        return true;
    }

}
?>