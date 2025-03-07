<?php // Venta.php
class Venta {
    private $producto_id;
    private $user_id;
    private $fechaVenta;
    private $comprador_id;
    private $precio;

    public function __construct($producto_id, $user_id, $fechaVenta, $comprador_id, $precio) {
        $this->producto_id = $producto_id;
        $this->user_id = $user_id;
        $this->fechaVenta = $fechaVenta;
        $this->comprador_id = $comprador_id;
        $this->precio = $precio;
    }

    public function getProductoId() {
        return $this->producto_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getFechaVenta() {
        return $this->fechaVenta;
    }

    public function getCompradorId() {
        return $this->comprador_id;
    }

    public function getPrecio() {
        return $this->precio;
    }
}
?>