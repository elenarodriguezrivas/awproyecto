<?php
require_once __DIR__ . '/../Producto/sa/ProductoSA.php';
require_once __DIR__ . '/../Producto/model/Anuncio.php';

$productoSA = new ProductoSA();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id' => filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING),
        'nombreProducto' => filter_input(INPUT_POST, 'nombreProducto', FILTER_SANITIZE_STRING),
        'descripcionProducto' => filter_input(INPUT_POST, 'descripcionProducto', FILTER_SANITIZE_STRING),
        'precio' => filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT),
        'vendedor' => filter_input(INPUT_POST, 'idVendedor', FILTER_SANITIZE_STRING),
        'comprador' => filter_input(INPUT_POST, 'comprador', FILTER_SANITIZE_STRING) ?? null,
    ];

    echo $productoSA->agregarProducto($datos);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar productos
    header('Content-Type: application/json');
    echo json_encode($productoSA->listarProductos());
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obtener el ID del producto desde la URL
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = filter_var($_DELETE['id'] ?? null, FILTER_VALIDATE_INT);

    if (!$id) {
        http_response_code(400);
        echo "ID inválido.";
        exit;
    }

    echo $productoSA->eliminarProducto($id);
    exit;
}
?>
