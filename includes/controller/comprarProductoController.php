<?php
session_start(); // Inicia la sesión

require_once __DIR__ . '/../Ventas/sa/registrarVentaSA.php';

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

    // Crear una instancia del servicio de aplicación para registrar la venta
    $ventaSA = new registrarVentaSA();

    try {
        // Llamar al método para registrar la venta
        echo $username;
        echo $producto_id;
        $ex = $ventaSA->registrarVenta($producto_id, $username);
        echo $ex;
        if ($ex) {
            http_response_code(200); // OK
            echo "Producto vendido con éxito.";
        } else {
            http_response_code(409); // Conflict
            echo "No se pudo registrar la venta del producto.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo "Error al procesar la venta: " . $e->getMessage();
    }
    exit;
}
?>
