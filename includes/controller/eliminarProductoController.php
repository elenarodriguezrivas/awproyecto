<?php
require_once __DIR__ . '/../Producto/sa/eliminarProductoSA.php';
require_once __DIR__ . '/../Producto/model/Producto.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['userid'])) {
        http_response_code(403); // No autorizado
        echo "Debes iniciar sesión.";
        exit;
    }

    $nombreProducto = htmlspecialchars(trim($_POST['nombreProducto']), ENT_QUOTES, 'UTF-8');

    if (empty($nombreProducto)) {
        http_response_code(400); // Bad Request
        echo "El nombre del producto no puede estar vacío.";
        exit;
    }

    $productoSA = new eliminarProductoSA();

    try {
        $resultado = $productoSA->eliminarProducto($nombreProducto, $_SESSION['userid']);

        if ($resultado->getMessage() === "Producto eliminado correctamente") {
            http_response_code(200); // OK
            echo $resultado->getMessage();
        } else {
            http_response_code(409); // Conflict
            echo "No se ha podido eliminar el producto.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
    exit;
}
?>
