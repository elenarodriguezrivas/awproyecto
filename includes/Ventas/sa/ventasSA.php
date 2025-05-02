<?php

require_once __DIR__ . '/../dao/VentaDAO.php';
require_once __DIR__ . '/../../Producto/dao/ProductoDAO.php';

class VentasSA {
    private $ventaDAO;
    private $productoDAO;

    public function __construct() {
        $this->ventaDAO = new VentaDAO();
        $this->productoDAO = new ProductoDAO();
    }

    public function registrarVenta($userid, $cesta) {
        foreach ($cesta as $producto) {
            $productoId = $producto['id'];
            $cantidad = $producto['cantidad'];

            // Obtener el vendedor del producto
            $vendedorId = $this->productoDAO->obtenerVendedorPorProductoId($productoId);

            // Registrar la venta
            $venta = new Venta($productoId, $userid, $vendedorId);
            if (!$this->ventaDAO->registrarVenta($venta)) {
                return false;
            }

            // Actualizar el estado del producto a "vendido"
            if (!$this->productoDAO->venta($productoId)) {
                return false;
            }
        }
        return true;
    }

    public function obtenerComprasPorUsuario($userid) {
        return $this->ventaDAO->obtenerComprasPorUsuario($userid);
    }
}
?>