<?php

require_once __DIR__ . '/../Producto/sa/registerProductoSA.php';
require_once __DIR__ . '/../Producto/model/Producto.php';

class registerProductoController
{
    private $subirProductoSA;

    public function __construct()
    {
        $this->subirProductoSA = new RegisterProductoSA();
    }

    public function registerProducto(Producto $producto)
    {
        $producto = $this->subirProductoSA->agregarProducto($producto);
        if ($producto) {
            return $producto;
        } else {
            return null;
        }
    }
}
