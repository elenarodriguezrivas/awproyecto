<?php
session_start();
require_once __DIR__ . '/../Producto/sa/registerProductoSA.php';
require_once __DIR__ . '/../Producto/model/Producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProducto = htmlspecialchars($_POST['nombreProducto'], ENT_QUOTES, 'UTF-8');
    $descripcionProducto = htmlspecialchars($_POST['descripcionProducto'], ENT_QUOTES, 'UTF-8');
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $categoriaProducto = htmlspecialchars($_POST['categoriaProducto'], ENT_QUOTES, 'UTF-8');
    $fechaRegistroProducto = filter_input(INPUT_POST, 'fecharegistroproducto', FILTER_VALIDATE_INT);
    if (!$nombreProducto) {
        http_response_code(400); 
        echo "Error: Contraseña inválida.";
        exit;
    }
    if (!$descripcionProducto) {
        http_response_code(400); 
        echo "Error: Email inválido.";
        exit;
    }
    if (!$precio) {
        http_response_code(400); 
        echo "Error: Nombre inválido.";
        exit;
    }
    if (!$categoriaProducto) {
        http_response_code(400); 
        echo "Error: Apellidos inválidos.";
        exit;
    }

    $producto = new Producto($nombreProducto, $descripcionProducto, $precio, $categoriaProducto, $_SESSION['userid']);
    
    $productoSA = new registerProductoSA();

    try {
        if ($productoSA->agregarProducto($producto)) {

            http_response_code(201); 
            echo "Producto registrado con éxito.";
        } else {
            http_response_code(409); // 
            echo "El producto no se ha podido registrar";
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error al registrar el producto: " . $e->getMessage();
    }
    exit;
}
?>