<?php
session_start();
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //permite mandarlo en la llamada get
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

$listarProductoSA = new listarProductosSA();
$productos = $listarProductoSA->listarProductosPaginados($offset, $limit);

$totalProductos = $listarProductoSA->contarProductos();
$totalPaginas = ceil($totalProductos / $limit);

$productosArray = [];
foreach ($productos as $producto) {
    $productosArray[] = [
        'id' => $producto->getId(),
        'nombreProducto' => $producto->getNombreProducto(),
        'descripcionProducto' => $producto->getDescripcionProducto(),
        'precio' => $producto->getPrecio(),
        'categoriaProducto' => $producto->getCategoriaProducto(),
        'rutaImagen' => $producto->getRutaImagen(),
        'estado' => $producto->getEstado()
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'productos' => $productosArray,
    'totalPaginas' => $totalPaginas,
    'paginaActual' => $page
]);
?>