<?php
session_start();
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Producto/dao/ProductoDAO.php';
require_once __DIR__.'/../Producto/model/Producto.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    http_response_code(401);
    echo "No se ha iniciado sesión.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $nombreProducto = htmlspecialchars($_POST['nombreProducto'], ENT_QUOTES, 'UTF-8');
    $descripcionProducto = htmlspecialchars($_POST['descripcionProducto'], ENT_QUOTES, 'UTF-8');
    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
    $categoriaProducto = htmlspecialchars($_POST['categoriaProducto'], ENT_QUOTES, 'UTF-8');

    // Validar datos
    if (!$id) {
        http_response_code(400);
        echo "ID de producto no válido.";
        exit;
    }

    if (!$nombreProducto || empty($nombreProducto)) {
        http_response_code(400);
        echo "El nombre del producto no puede estar vacío.";
        exit;
    }
    
    if (!$descripcionProducto || empty($descripcionProducto)) {
        http_response_code(400);
        echo "La descripción del producto no puede estar vacía.";
        exit;
    }
    
    if (!$precio || $precio <= 0) {
        http_response_code(400);
        echo "El precio debe ser mayor que cero.";
        exit;
    }
    
    if (!$categoriaProducto || empty($categoriaProducto)) {
        http_response_code(400);
        echo "Debe seleccionar una categoría.";
        exit;
    }

    // Obtener el producto actual
    $productoDAO = new ProductoDAO();
    $productoActual = $productoDAO->obtenerProductoPorId($id);
    
    if (!$productoActual) {
        http_response_code(404);
        echo "Producto no encontrado.";
        exit;
    }

    // Verificar que el usuario actual es el propietario del producto
    if ($productoActual->getIdVendedor() !== $_SESSION['userid']) {
        http_response_code(403);
        echo "No tienes permiso para modificar este producto.";
        exit;
    }

    // Manejar la imagen si se ha subido una nueva
    $rutaImagen = $productoActual->getRutaImagen(); // Usar la imagen actual por defecto
    
    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK && $_FILES['imagenProducto']['size'] > 0) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($_FILES['imagenProducto']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $extensionesPermitidas)) {
            http_response_code(400);
            echo "El formato de la imagen no es válido. Solo se permiten JPEG, PNG, GIF y WEBP.";
            exit;
        }
        
        // Crear un nombre único para la imagen
        $nombreImagen = uniqid() . '_' . basename($_FILES['imagenProducto']['name']);
        $directorioDestino = __DIR__ . '/../../fotos/';
        
        // Asegúrate de que el directorio existe
        if (!is_dir($directorioDestino)) {
            if (!mkdir($directorioDestino, 0777, true)) {
                http_response_code(500);
                echo "Error al crear el directorio para las imágenes.";
                exit;
            }
        }
        
        // Ruta completa del archivo
        $rutaDestino = $directorioDestino . $nombreImagen;
        
        if (move_uploaded_file($_FILES['imagenProducto']['tmp_name'], $rutaDestino)) {
            $rutaImagen = 'fotos/' . $nombreImagen;
        } else {
            http_response_code(500);
            echo "Error al subir la nueva imagen.";
            exit;
        }
    }

    // Crear objeto Producto con los datos actualizados
    $productoActualizado = new Producto(
        $id,
        $nombreProducto,
        $descripcionProducto,
        $precio,
        $categoriaProducto,
        $_SESSION['userid'],
        $rutaImagen,
        $productoActual->getEstado()
    );
    
    // Actualizar el producto en la base de datos
    if ($productoDAO->actualizarProducto($productoActualizado)) {
        http_response_code(200);
        echo "Producto actualizado correctamente.";
    } else {
        http_response_code(500);
        echo "Error al actualizar el producto.";
    }
    
    exit;
}
?>