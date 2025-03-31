<?php // Venta.php
class Venta {
    private $producto_id;
    private $comprador_id;
    private $vendedor_id;

    public function __construct($producto_id,$comprador_id, $vendedor_id) {
        $this->producto_id = $producto_id;
        $this->comprador_id = $comprador_id;
        $this->vendedor_id = $vendedor_id;
    }

    public function getProductoId() {
        return $this->producto_id;
    }

    public function getCompradorId() {
        return $this->comprador_id;
    }

    public function getVendedorId() {
        return $this->vendedor_id;
    }

}
?>