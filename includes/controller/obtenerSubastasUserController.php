<?php
session_start();
require_once __DIR__ . '/../Subasta/sa/listarSubastasSA.php';

$listarSubastaSA = new listarSubastasSA();
$subastas = $listarSubastaSA->listarSubastasUser($_SESSION['userid']);

$subastasArray = [];
foreach ($productos as $producto) {
    $subastasArray[] = [
        'nombreSubasta' = $subasta->getNombreSubasta(),
        'descripcionSubasta' = $subasta->getDescripcionSubasta(),
        'precio_original' = $subasta->getPrecio_original(),
        'precio_actual' = $subasta->getPrecio_actual(),
        'idVendedor' = $subasta->getIdVendedor(),
        'rutaImagen' = $subasta->getRutaImagen(),
        'estado' = $subasta->getEstado(),
        'fechaSubasta' = $subasta->getFechaSubasta(),
        'horaSubasta' = $subasta->getHoraSubasta()
    ];
}

header('Content-Type: application/json');
echo json_encode($subastasArray);
?>