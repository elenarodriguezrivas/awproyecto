<?php

class Producto {
    private $id;
    private $nombreProducto;
    private $descripcionProducto;
    private $precio;
    private $vendedor;
    private $comprador;

    public function __construct($nombreProducto, $descripcionProducto, $precio, $vendedor, $comprador = NULL) {
        $this->nombreProducto = $nombreProducto;
        $this->descripcionProducto = $descripcionProducto;
        $this->precio = $precio;
        $this->vendedor = $vendedor;
        $this->comprador = $comprador;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombreProducto() {
        return $this->nombreProducto;
    }

    public function getDescripcionProducto() {
        return $this->descripcionProducto;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getVendedor() {
        return $this->vendedor;
    }

    public function getComprador() {
        return $this->comprador;
    }

    public function isSold() {
        return $this->comprador !== NULL;
    }
}
?>