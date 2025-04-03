<?php
session_start();
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';
require_once __DIR__ . '/../Producto/sa/buscarProductosPorCategoriaSA.php';

$listarProductoSA = new listarProductosSA();
$productos = $listarProductoSA->listarProductos();
/*
if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $listarProductoSA = new buscarProductosPorCategoriaSA();
    $productos = $listarProductoSA->buscarProductosPorCategoria($categoria);
    console.log("Me meto en controller con categoria");
    console.log($_GET['categoria']);
}*/
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $listarProductoSA = new buscarProductosPorCategoriaSA();
    $productos = $listarProductoSA->buscarProductosPorCategoria($categoria);
    error_log("Me meto en controller con categoría: " . $categoria);
}


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