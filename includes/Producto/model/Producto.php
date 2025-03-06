<?php

class Producto { //Producto
    private $id;
    private $nombreProducto;
    private $descripcionProducto;
    private $precio;
    private $categoriaProducto;
    //private $fechaRegistroProducto;
    private $idVendedor;

    public function __construct($nombreProducto, $descripcionProducto, $precio, $categoriaProducto, $idVendedor) {
        $this->nombreProducto = $nombreProducto;
        $this->descripcionProducto = $descripcionProducto;
        $this->precio = $precio;
        $this->categoriaProducto = $categoriaProducto;
        $this->idVendedor = $idVendedor;
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

    public function getcategoriaProducto() {
        return $this->categoriaProducto;
    }

    public function getIdVendedor(){
        return $this->idVendedor;
    }
}
?>