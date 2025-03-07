<?php
session_start();
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';

$listarProductoSA = new listarProductosSA();
$productos = $listarProductoSA->listarMisProductos();

$productosArray = [];
foreach ($productos as $producto) {
    $productosArray[] = [
        'nombreProducto' => $producto->getNombreProducto(),
        'descripcionProducto' => $producto->getDescripcionProducto(),
        'precio' => $producto->getPrecio(),
        'categoriaProducto' => $producto->getcategoriaProducto(),
        'rutaImagen' => $producto->getRutaImagen()
    ];
}

header('Content-Type: application/json');
echo json_encode($productosArray);
?>