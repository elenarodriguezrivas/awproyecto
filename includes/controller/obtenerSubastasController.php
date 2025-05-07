<?php
session_start();

require_once __DIR__ . '/../Subasta/sa/listarSubastasSA.php';

$listarSubastaSA = new listarSubastasSA();
$subastas = $listarSubastaSA->listarSubastas();

$subastasArray = [];
foreach ($subastas as $subasta) {
    $subastasArray[] = [
        'id' => $subasta->getId(),
        'nombreSubasta' => $subasta->getNombreSubasta(),
        'descripcionSubasta' => $subasta->getDescripcionSubasta(),
        'precio_original' => $subasta->getPrecio_original(),
        'precio_actual' => $subasta->getPrecio_actual(),
        'rutaImagen' => $subasta->getRutaImagen(),
        'estado' => $subasta->getEstado(),
        'fechaSubasta' => $subasta->getFechaSubasta(),
        'horaSubasta' => $subasta->getHoraSubasta()
    ];
}

header('Content-Type: application/json');
echo json_encode($subastasArray);
?>