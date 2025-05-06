<?php
session_start();
require_once __DIR__ . '/../Subasta/sa/listarSubastasSA.php';

$listarSubastasSA = new listarSubastasSA();
$subastas = $listarSubastaSA->listarSubastas();

$subastasArray = [];
foreach ($subastas as $subasta) {
    $subastasArray[] = [
        'id' => $subasta->getId(),
        'nombreSubasta' => $subasta->getNombreSubasta(),
        'descripcionSubasta' => $subasta->getDescripcionSubasta(),
        'precio_original' => $subasta->getPrecio_original(),
        'rutaImagen' => $subasta->getRutaImagen(),
        'estado' => $subasta->getEstado()
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'subastas' => $subastasArray,
    'totalPaginas' => $totalPaginas,
    'paginaActual' => $page
]);
?>