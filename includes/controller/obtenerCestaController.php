<?php
session_start();
require_once __DIR__ . '/../Cestas/sa/obtenerCestaSA.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['userid'])) {
        echo json_encode([
            'success' => false,
            'message' => 'El usuario no ha iniciado sesión.'
        ]);
        exit;
    }

    $obtenerCestaSA = new obtenerCestaSA();
    $cesta = $obtenerCestaSA->obtenerCesta($_SESSION['userid']);

    if ($cesta) {
        $productosArray = [];
        foreach ($cesta->getProductosCesta() as $producto) {
            $productosArray[] = [
                'id' => $producto->getId(),
                'nombreProducto' => $producto->getNombreProducto(),
                'descripcionProducto' => $producto->getDescripcionProducto(),
                'precio' => $producto->getPrecio(),
                'categoriaProducto' => $producto->getcategoriaProducto(),
                'vendedorId' => $producto->getIdVendedor(),
                'rutaImagen' => $producto->getRutaImagen(),
                'estado' => $producto->getEstado()
            ];
        }

        echo json_encode([
            'success' => true,
            'productos' => $productosArray
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró la cesta para el usuario proporcionado.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor: ' . $e->getMessage()
    ]);
}
?>