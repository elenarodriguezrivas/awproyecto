<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido.";
    exit;
}

$idSubasta = filter_input(INPUT_POST, 'idSubasta', FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]);
$precio    = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);

if ($idSubasta === false || $precio === false || $precio <= 0) {
    http_response_code(400);
    echo "Error: Datos inválidos.";
    exit;
}

//Comprobar subasta y propietario
require_once __DIR__ . '/../Subasta/sa/registerSubastaSA.php';
$subastaSA = new registerSubastaSA();
$subasta = $subastaSA->obtenerSubastaPorId($idSubasta);
if (!$subasta) {
    http_response_code(404);
    echo "Subasta no encontrada.";
    exit;
}
if ($subasta->getIdVendedor() === $_SESSION['userid']) {
    http_response_code(403);
    echo "No puedes pujar en tu propia subasta.";
    exit;
}

if ($subasta->getEstado() !== 'en_subasta') {
    http_response_code(403);
    echo "La subasta ya está finalizada.";
    exit;
}

//Precio mínimo
$minActual = $subasta->getPrecio_actual();
if ($precio < $minActual) {
    http_response_code(400);
    echo "La puja debe ser al menos {$minActual}€.";
    exit;
}

//Registrar puja
require_once __DIR__ . '/../Puja/model/Puja.php';
require_once __DIR__ . '/../Puja/sa/registerPujaSA.php';

$puja = new Puja($idSubasta, $_SESSION['userid'], $precio);

$pujaSA = new registerPujaSA();
$ok = $pujaSA->agregarPuja($puja);

if ($ok) {
    if($subastaSA->actualizarPrecioActual($idSubasta, $precio)){
        http_response_code(201);
        echo "Puja registrada con éxito.";
    }
} else {
    http_response_code(409);
    echo "La puja no se ha podido registrar (quizá ya existe).";
}
exit;
