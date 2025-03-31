<?php
session_start(); // Inicia la sesión

require_once __DIR__ . '/../Producto/sa/eliminarProductoSA.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para registrar un producto.");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el JSON enviado en el cuerpo de la solicitud
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decodificar el JSON a un array asociativo

    // Validar que el ID del producto esté presente
    if (empty($data['id'])) {
        http_response_code(400); // Bad Request
        echo "El ID del producto es obligatorio.";
        exit;
    }

    $producto_id = $data['id']; // Obtener el ID del producto

    // Obtener el nombre de usuario desde la sesión
    if (empty($_SESSION['userid'])) {
        http_response_code(401); // Unauthorized
        echo "No se ha iniciado sesión.";
        exit;
    }

    $username = $_SESSION['userid']; // Obtener el nombre de usuario desde la sesión

    $productoSA = new eliminarProductoSA();

    try {
        $resultado = $productoSA->eliminarProducto($producto_id, $username);

        if ($resultado && $resultado->message === "Producto eliminado correctamente") {
            http_response_code(200); // OK
            echo $resultado->message;
        } else {
            http_response_code(409); // Conflict
            echo $resultado ? $resultado->message : "No se ha podido eliminar el producto.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo "Error al eliminar el producto: " . $e->getMessage();
    }
    exit;
}
?>