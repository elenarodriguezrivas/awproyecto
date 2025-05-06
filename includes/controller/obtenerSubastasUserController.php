<?php
session_start();
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';

$listarProductoSA = new listarProductosSA();
$productos = $listarProductoSA->listarProductosUser($_SESSION['userid']);

$productosArray = [];
foreach ($productos as $producto) {
    $productosArray[] = [
        'id' => $producto->getId(),
        'nombreProducto' => $producto->getNombreProducto(),
        'descripcionProducto' => $producto->getDescripcionProducto(),
        'precio' => $producto->getPrecio(),
        'categoriaProducto' => $producto->getcategoriaProducto(),
        'vendedorId' => $producto->getIdVendedor(),
        'rutaImagen' => $producto->getRutaImagen(),
        'estado' => $producto->getEstado()
    ];
}

header('Content-Type: application/json');
echo json_encode($productosArray);
?>