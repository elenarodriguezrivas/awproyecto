<?php
require_once __DIR__ . '/../Producto/sa/listarProductosSA.php';

$listarProductoSA = new listarProductosSA();
$productos = $listarProductoSA->listarProductos();

header('Content-Type: application/json');
echo json_encode($productos);
?>