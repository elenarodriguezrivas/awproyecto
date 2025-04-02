<?php
session_start();
require_once __DIR__ . '/../Producto/sa/buscarProductosPorCategoriaSA.php';

if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    
    $buscarProductosSA = new buscarProductosPorCategoriaSA();
    $productos = $buscarProductosSA->buscarProductosPorCategoria($categoria);

    $productosArray = [];
    foreach ($productos as $producto) {
        $productosArray[] = [
            'nombreProducto' => $producto->getNombreProducto(),
            'descripcionProducto' => $producto->getDescripcionProducto(),
            'precio' => $producto->getPrecio(),
            'categoriaProducto' => $producto->getCategoriaProducto(),
            'rutaImagen' => $producto->getRutaImagen()
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($productosArray);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Categoría no proporcionada']);
}
?>