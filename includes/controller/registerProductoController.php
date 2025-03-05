<?php

require_once __DIR__ . '/../Productos/sa/crearProductoSA.php';

class registerProductoController
{
    private $subirProductoSA;

    public function __construct()
    {
        $this->subirProductoSA = new RegisterProductoSA();
    }

    public function crearProducto(Producto $producto)
    {
        $producto = $this->subirProductoSA->agregarProducto($producto);
        if ($producto) {
            return $producto;
        } else {
            return null;
        }
    }
}
