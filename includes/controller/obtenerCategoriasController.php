<?php
session_start();
require_once __DIR__ . '/../Categorias/sa/listarCategoriasSA.php';

$listarCategoriasSA = new listarCategoriasSA();
$categorias = $listarCategoriasSA->listarCategorias();

$categoriasArray = [];

foreach ($categorias as $categoria) {
    $categoriasArray[] = [
        'nombreCategoria' => $categoria->getCategoria()
    ];
}

header('Content-Type: application/json');
echo json_encode($categoriasArray);
?>