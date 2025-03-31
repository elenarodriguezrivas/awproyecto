<?php
session_start();
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';

$listarProductoSA = new listarProductosSA();
$productos = $listarProductoSA->listarProductos();

$productosArray = [];
foreach ($productos as $producto) {
    $productosArray[] = [
        'id' => $producto->getId(),
        'nombreProducto' => $producto->getNombreProducto(),
        'descripcionProducto' => $producto->getDescripcionProducto(),
        'precio' => $producto->getPrecio(),
        'categoriaProducto' => $producto->getcategoriaProducto(),
        'rutaImagen' => $producto->getRutaImagen(),
        'estado' => $producto->getEstado()
    ];
}

header('Content-Type: application/json');
echo json_encode($productosArray);
?>