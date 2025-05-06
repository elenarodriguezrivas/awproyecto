<?php
session_start();
if (!isset($_SESSION['userid'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No ha iniciado sesión']);
    exit;
}
require_once __DIR__ . '/../Subasta/sa/listarSubastasSA.php';

$listarSubastaSA = new listarSubastasSA();
$subastas = $listarSubastaSA->listarSubastasUser($_SESSION['userid']);

$subastasArray = [];
foreach ($subastas as $subasta) {
    $subastasArray[] = [
        'nombreSubasta' => $subasta->getNombreSubasta(),
        'descripcionSubasta' => $subasta->getDescripcionSubasta(),
        'precio_original' => $subasta->getPrecio_original(),
        'precio_actual' => $subasta->getPrecio_actual(),
        'idVendedor' => $subasta->getIdVendedor(),
        'rutaImagen' => $subasta->getRutaImagen(),
        'estado' => $subasta->getEstado(),
        'fechaSubasta' => $subasta->getFechaSubasta(),
        'horaSubasta' => $subasta->getHoraSubasta()
    ];
}

header('Content-Type: application/json');
echo json_encode($subastasArray);
?>