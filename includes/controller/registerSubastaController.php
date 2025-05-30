<?php
session_start();
require_once __DIR__ . '/../Subasta/sa/registerSubastaSA.php';
require_once __DIR__ . '/../Subasta/model/Subasta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreSubasta = htmlspecialchars($_POST['nombreSubasta'], ENT_QUOTES, 'UTF-8');
    $descripcionSubasta = htmlspecialchars($_POST['descripcionSubasta'], ENT_QUOTES, 'UTF-8');
    $precio_original = filter_var($_POST['precio_original'], FILTER_VALIDATE_FLOAT);
    //el precio actual no lo registra el vendedor
    $fechaSubasta = $_POST['fechaSubasta']; // “YYYY-MM-DD”
    $horaSubasta  = $_POST['horaSubasta'];  // “HH:MM”

    // Validar fecha
    $dtF = DateTime::createFromFormat('Y-m-d', $fechaSubasta);
    $isFechaValida = $dtF && $dtF->format('Y-m-d') === $fechaSubasta;

    // Validar hora
    $dtH = DateTime::createFromFormat('H:i', $horaSubasta);
    $isHoraValida = $dtH && $dtH->format('H:i') === $horaSubasta;

    $hoy   = new DateTime('today'); //Comprobacion de que no se puede registrar una fecha de subasta anterior a hoy
    if (!$dtF || $dtF < $hoy) {
        http_response_code(400);
        echo "Error: La fecha de subasta debe ser hoy o una fecha futura.";
        exit;
    }

    if (! $isFechaValida) {
        http_response_code(400);
        echo "Formato de fecha no válido.";
        exit;
    }
    if (! $isHoraValida) {
        http_response_code(400);
        echo "Formato de hora no válido.";
        exit;
    }

    if (!$nombreSubasta || empty($nombreSubasta)) {
        http_response_code(400);
        echo "El nombre de la subasta no puede estar vacío.";
        exit;
    }
    
    if (!$descripcionSubasta || empty($descripcionSubasta)) {
        http_response_code(400);
        echo "La descripción de la subasta no puede estar vacía.";
        exit;
    }
    
    if (!$precio_original || $precio_original <= 0) {
        http_response_code(400);
        echo "El precio debe ser mayor que cero.";
        exit;
    }

    $estado = $_POST['estado'] ?? 'en_subasta';    

    if (isset($_FILES['imagenSubasta']) && $_FILES['imagenSubasta']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['imagenSubasta']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = bin2hex(random_bytes(8)) . '.' . $extension;
        $directorioDestino = __DIR__ . '/../../fotos/';
        $rutaArchivo = $directorioDestino . $nombreArchivo;
    
        // Crear el directorio si no existe
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }
    
        // Mover el archivo subido al directorio de destino
        if (move_uploaded_file($_FILES['imagenSubasta']['tmp_name'], $rutaArchivo)) {
            $rutaImagen = '/fotos/' . $nombreArchivo;
            echo "Imagen guardada en: " . $rutaImagen;
        } else {
            http_response_code(500);
            echo "Error al subir la imagen.";
            exit;
        }
    } else {
        http_response_code(400);
        echo "Error: Imagen no válida.";
        exit;
    }
    
    $subasta = new Subasta(NULL, $nombreSubasta, $descripcionSubasta, $precio_original, $precio_original, $_SESSION['userid'], $rutaImagen, $estado, $fechaSubasta, $horaSubasta);

    $subastaSA = new registerSubastaSA();

    try {
        if ($subastaSA->agregarSubasta($subasta)) {
            http_response_code(201); 
            echo "Subasta registrada con éxito.";
        } else {
            http_response_code(409); 
            echo "La subasta no se ha podido registrar";
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error al registrar la subasta: " . $e->getMessage();
    }
    exit;
}
?>