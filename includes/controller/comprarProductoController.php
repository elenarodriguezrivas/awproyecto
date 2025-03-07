<?php
session_start(); // Inicia la sesión

require_once __DIR__ . '/../Ventas/model/Venta.php';
require_once __DIR__ . '/../Ventas/sa/registrarVentaSA.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del producto y comprador
    $producto_id = $_POST['producto_id'];
    $precio = $_POST['precio'];
    
    // Obtener la fecha de la venta desde la sesión (la fecha de la compra)
    if (!isset($_SESSION['fechaVenta'])) {
        $_SESSION['fechaVenta'] = date('Ymd');  // Si no existe, la asignamos
    }
    $fechaVenta = $_SESSION['fechaVenta'];  // Usamos la fecha de la venta desde la sesión

    // Obtener el idVendedor desde el producto (esto debería venir de la base de datos)
    require_once __DIR__ . '/../Productos/sa/obtenerProductoPorIdSA.php'; // Asegúrate de incluir la clase que obtiene los productos
    $productoSA = new obtenerProductoPorIdSA();
    $producto = $productoSA->obtenerProductoPorId($producto_id); // Este método debe devolver un producto con el idVendedor
    $user_id = $producto['idVendedor']; // El idVendedor es el propietario del producto

    // El comprador es el usuario que ha iniciado sesión
    $comprador_id = $_SESSION['userid'];  // El usuario logueado

    // Crear una instancia de la venta
    $venta = new Venta($producto_id, $user_id, $fechaVenta, $comprador_id, $precio);
    $ventaSA = new registrarVentaSA();

    try {
        if ($ventaSA->registrarVentaSA($venta)) {
            http_response_code(201); 
            echo "Producto vendido con éxito.";
            // Limpiar la fecha de venta después de la compra, si ya no es necesaria
            unset($_SESSION['fechaVenta']);
        } else {
            http_response_code(409); 
            echo "El producto no se ha podido vender";
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error al vender el producto: " . $e->getMessage();
    }
    exit;
}
?>
