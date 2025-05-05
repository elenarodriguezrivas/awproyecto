<?php
//session_start();
require_once __DIR__ . '/../Subasta/sa/listarSubastasSA.php';

$listarSubastasSA = new listarSubastasSA();
$subastas = $listarSubastasSA->obtenerProductosSubastados();

header('Content-Type: application/json');
echo json_encode($productosEnSubasta);
?>