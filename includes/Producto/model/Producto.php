<?php

class Producto { //Producto
    private $id;
    private $nombreProducto;
    private $descripcionProducto;
    private $precio;
    private $categoriaProducto;
    private $fechaRegistroProducto;
    private $idVendedor;

    public function __construct($id, $nombreProducto, $descripcionProducto, $precio, $categoriaProducto, $fechaRegistroProducto, $idVendedor) {
        $this->id = $id;
        $this->nombreProducto = $nombreProducto;
        $this->descripcionProducto = $descripcionProducto;
        $this->precio = $precio;
        $this->categoriaProducto = $categoriaProducto;
        $this->fechaRegistroProducto = $fechaRegistroProducto;
        $this->idVendedor = $idVendedor;
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

    public function getcategoriaProducto() {
        return $this->categoriaProducto;
    }

    public function getfechaRegistroProducto() {
        return $this->fechaRegistroProducto;
    }

    public function getIdVendedor(){
        return $this->idVendedor;
    }
}
?>