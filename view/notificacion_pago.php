<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/redsys/apiRedsys.php';

$miObj = new RedsysAPI;

if (!empty($_POST)) {
    $version = $_POST["Ds_SignatureVersion"];
    $params = $_POST["Ds_MerchantParameters"];
    $signatureRecibida = $_POST["Ds_Signature"];
    
    // Verificar firma
    $firmaCalculada = $miObj->createMerchantSignatureNotif(SECRET_KEY, $params);
    
    if ($firmaCalculada === $signatureRecibida) {
        $decodec = $miObj->decodeMerchantParameters($params);
        $order = $decodec['Ds_Order'];
        $response = $decodec['Ds_Response'];
        
        // Registrar la respuesta en tu base de datos
        registrarRespuestaPago($order, $response, $params);
    }
    
    // RedSys espera una respuesta vacía
    exit;
}

function registrarRespuestaPago($order, $response, $params) {
    // Implementa tu lógica para guardar la respuesta
    // Ejemplo básico:
    file_put_contents('pagos.log', "[".date('Y-m-d H:i:s')."] Order: $order, Response: $response\nParams: $params\n\n", FILE_APPEND);
}