<?php
session_start();
require_once __DIR__ . '/../Producto/sa/eliminarProductoSA.php';
require_once __DIR__ . '/../Producto/model/Producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Solo cogemos el nombre
    $nombreProducto = htmlspecialchars($_POST['nombreProducto'], ENT_QUOTES, 'UTF-8');
    // Verificar si los datos son válidos
    if (!$nombreProducto) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: nombre inválido.";
        exit;
    }

    // Instanciar servicio de aplicación
    $productoSA = new eliminarProductoSA();

    // Intentar eliminar al producto
    try {
        if ($productoSA->eliminarProductoSA($nombreProducto, $_SESSION['userid'])) {

            http_response_code(201); // Código 201 - Created
            echo "Producto eliminado con éxito.";
        } else {
            http_response_code(409); // Código 409 - Conflict (usuario ya existe)
            echo "El producto no se ha podido eliminar";
        }
    } catch (Exception $e) {
        http_response_code(500); // Código 500 - Internal Server Error
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
    exit;
}
?>