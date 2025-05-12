<?php
session_start(); // Inicia la sesión

require_once __DIR__ . '/../Categorias/sa/eliminarCategoriaSA.php';

if (!isset($_SESSION['userid'])) { // Verifica si el usuario está autenticado
    header("Location: login_pantalla.php?error=Debes iniciar sesión para eliminar una categoria.");
    exit;
}
/*
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { //Debe ser un admin
    header("Location: index.php?error=Acceso restringido.");
    exit;
}*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el JSON enviado en el cuerpo de la solicitud
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true); // Decodificar el JSON a un array asociativo

    // Validar que el nombre de la categoria esté presente
    if (empty($data['nombreCategoria'])) {
        http_response_code(400); // Bad Request
        echo "El nombre de la categoria es obligatorio.";
        exit;
    }

    $nombreCategoria = $data['nombreCategoria']; // Obtener el nombre de la categoria

    $categoriaSA = new eliminarCategoriaSA();

    try {
        $resultado = $categoriaSA->eliminarCategoria($nombreCategoria);

        if ($resultado && $resultado->message === "Categoria eliminada correctamente") {
            http_response_code(200); // OK
            echo $resultado->message;
        } else {
            http_response_code(409); // Conflict
            echo $resultado ? $resultado->message : "No se ha podido eliminar la categoria.";
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo "Error al eliminar la categoria: " . $e->getMessage();
    }
    exit;
}
?>