<?php
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';

$listarProductosSA = new listarProductosSA();
$productos = $listarProductosSA->listarProductos();

header('Content-Type: application/json');
echo json_encode($productos);
?>