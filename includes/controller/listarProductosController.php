<?php
require_once __DIR__ . '/../Usuarios/sa/listarProductosSA.php';
session_start();

class ListarProductosController {
    private $listarProductoSA;

    public function __construct() {
        $this->listarProductoSA = new listarProductosSA();
    }

    public function listarProductos() {
        $arrayProductos = $this->listarProductoSA->listarProductos();
        $productos = [];

        for ($i = 0; $i < count($arrayProductos); $i++) {
            $producto = $arrayProductos[$i];
            $productos[] = [
                "nombre" => $producto->getNombreProducto(),
                "descripcion" => $producto->getDescripcionProducto(),
                "precio" => $producto->getPrecioProducto()
            ];
        }

        echo json_encode($productos);
    }
}

$controller = new ListarProductosController();
$controller->listarProductos();
?>
