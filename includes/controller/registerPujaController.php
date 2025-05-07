<?php
session_start();
require_once __DIR__ . '/../Puja/sa/registerPujaSA.php';
require_once __DIR__ . '/../Puja/model/Puja.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSubasta = filter_input(INPUT_POST, 'idSubasta', FILTER_VALIDATE_INT);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);

    if (!$idSubasta || !$precio) {
        http_response_code(400); 
        echo "Error: Datos inválidos.";
        exit;
    }  
    
    $puja = new Puja($idSubasta, $_SESSION['userid'], $precio);

    $pujaSA = new registerPujaSA();

    try {
        if ($pujaSA->agregarPuja($puja)) {
            http_response_code(201); 
            echo "Puja registrada con éxito.";
        } else {
            http_response_code(409); 
            echo "La puja no se ha podido registrar";
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error al registrar la puja: " . $e->getMessage();
    }
    exit;
}
?>