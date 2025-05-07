<?php
session_start();

//aqui hariamos lo de finalizarSUbastasSA.php
//CONVENIO con el profesor: para realizar pruebas de que se finalizan las subastas, se llama a dos SA desde el controlador obtenerSubastasController
//Es una solucion temporal, ya se ha comentado con el profesor que sería mejor realizar la funcionalidad de finalizar subastas con un trigger desde la base de datos
//pero para que sea más sencillo hacer comprobaciones, lo ponemos aquí
require_once __DIR__ . '/../Subasta/sa/finalizarSubastaSA.php';
$finalizarSubastaSA = new finalizarSubastaSA();
$finalizarSubastaSA->cerrarVencidas(); //cierra las subastas vencidas

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