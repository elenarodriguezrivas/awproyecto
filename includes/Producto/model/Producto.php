<?php

class Producto {
    private $id;
    private $nombreProducto;
    private $descripcionProducto;
    private $precio;
    private $categoriaProducto;
    private $idVendedor;
    private $rutaImagen;

    public function __construct($nombreProducto, $descripcionProducto, $precio, $categoriaProducto, $idVendedor, $rutaImagen) {
        $this->nombreProducto = $nombreProducto;
        $this->descripcionProducto = $descripcionProducto;
        $this->precio = $precio;
        $this->categoriaProducto = $categoriaProducto;
        $this->idVendedor = $idVendedor;
        $this->rutaImagen = $rutaImagen;
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

    public function getCategoriaProducto() {
        return $this->categoriaProducto;
    }

    public function getIdVendedor() {
        return $this->idVendedor;
    }

    public function getRutaImagen() {
        return $this->rutaImagen;
    }
}
?>