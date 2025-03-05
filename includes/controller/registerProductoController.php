<?php
session_start();
require_once __DIR__ . '/../Producto/sa/registerProductoSA.php';
require_once __DIR__ . '/../Producto/model/Producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Filtrar y validar entrada del producto
    //id del producto se autoincrementa
    $nombreProducto = htmlspecialchars($_POST['nombreProducto'], ENT_QUOTES, 'UTF-8');
    $descripcionProducto = htmlspecialchars($_POST['descripcionProducto'], ENT_QUOTES, 'UTF-8');
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $categoriaProducto = htmlspecialchars($_POST['categoriaProducto'], ENT_QUOTES, 'UTF-8');
    $fechaRegistroProducto = filter_input(INPUT_POST, 'fecharegistroproducto', FILTER_VALIDATE_INT);
    $idVendedor = htmlspecialchars($_POST['idVendedor'], ENT_QUOTES, 'UTF-8');

    // Verificar si los datos son válidos
    if (!$nombreProducto) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Contraseña inválida.";
        exit;
    }
    if (!$descripcionProducto) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Email inválido.";
        exit;
    }
    if (!$precio) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Nombre inválido.";
        exit;
    }
    if (!$categoriaProducto) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Apellidos inválidos.";
        exit;
    }
    if (!$fechaRegistroProducto) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Edad inválida.";
        exit;
    }
    if (!$idVendedor) {
        http_response_code(400); // Código de error 400 - Bad Request
        echo "Error: Edad inválida.";
        exit;
    }

    // Crear el objeto usuario
    $producto = new Producto($nombreProducto, $descripcionProducto, $precio, $categoriaProducto, $fechaRegistroProducto, $idVendedor);
    
    // Instanciar servicio de aplicación
    $productoSA = new registerProductoSA();

    // Intentar registrar al producto
    try {
        if ($productoSA->agregarProducto($producto)) {
            $_SESSION['nombreProducto'] = $producto->getNombreProducto();
            $_SESSION['descripcionProducto'] = $producto->getDescripcionProducto();
            $_SESSION['precio'] = $producto->getPrecio();
            $_SESSION['categoriaProducto'] = $producto->getcategoriaProducto();
            $_SESSION['fechaRegistroProducto'] = $producto->getfechaRegistroProducto();
            $_SESSION['idVendedor'] = $producto->getIdVendedor();

            http_response_code(201); // Código 201 - Created
            echo "Producto registrado con éxito.";
        } else {
            http_response_code(409); // Código 409 - Conflict (usuario ya existe)
            echo "El producto ya existe.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Código 500 - Internal Server Error
        echo "Error al registrar el producto: " . $e->getMessage();
    }
    exit;
}
?>