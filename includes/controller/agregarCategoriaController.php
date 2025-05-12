<?php
session_start();
require_once __DIR__ . '/../Categorias/sa/agregarCategoriaSA.php';
require_once __DIR__ . '/../Categorias/model/Categoria.php';
/*
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { //Debe ser un admin
    header("Location: index.php?error=Acceso restringido.");
    exit;
}*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCategoria = htmlspecialchars($_POST['categoria'], ENT_QUOTES, 'UTF-8'); 

    if (!$nombreCategoria) {
        http_response_code(400); 
        echo "Error: Datos inválidos.";
        exit;
    }

    $categoria = new Categoria($nombreCategoria);
    
    $categoriaSA = new agregarCategoriaSA();

    try {
        if ($categoriaSA->agregarCategoria($categoria)) {
            http_response_code(201); 
            echo "Categoria agregada con éxito.";
        } else {
            http_response_code(409); 
            echo "La categoria no se ha podido agregar";
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error al agregar la categoria: " . $e->getMessage();
    }
    exit;
}
?>