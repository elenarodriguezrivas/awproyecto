<?php
session_start();
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Subasta/dao/SubastaDAO.php';
require_once __DIR__.'/../Subasta/model/Subasta.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    http_response_code(401);
    echo "No se ha iniciado sesión.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $nombreSubasta = htmlspecialchars($_POST['nombreSubasta'], ENT_QUOTES, 'UTF-8');
    $descripcionSubasta = htmlspecialchars($_POST['descripcionSubasta'], ENT_QUOTES, 'UTF-8');
    $precio_original = filter_var($_POST['precio_original'], FILTER_VALIDATE_FLOAT);
    //el precio actual no le permitimos modificarlo
    $fechaSubasta = $_POST['fechaSubasta']; // “YYYY-MM-DD”
    $horaSubasta  = $_POST['horaSubasta'];  // “HH:MM”

    // Validar fecha
    $dtF = DateTime::createFromFormat('Y-m-d', $fechaSubasta);
    $isFechaValida = $dtF && $dtF->format('Y-m-d') === $fechaSubasta;

    // Validar hora
    $dtH = DateTime::createFromFormat('H:i', $horaSubasta);
    $isHoraValida = $dtH && $dtH->format('H:i') === $horaSubasta;

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

    // Validar datos
    if (!$id) {
        http_response_code(400);
        echo "ID de subasta no válido.";
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

    // Obtener la subasta actual
    $subastaDAO = new SubastaDAO();
    $subastaActual = $subastaDAO->obtenerSubastaPorId($id);
    
    if (!$subastaActual) {
        http_response_code(404);
        echo "Subasta no encontrada.";
        exit;
    }

    // Verificar que el usuario actual es el propietario del producto
    if ($subastaActual->getIdVendedor() !== $_SESSION['userid']) {
        http_response_code(403);
        echo "No tienes permiso para modificar esta subasta.";
        exit;
    }

    // Manejar la imagen si se ha subido una nueva
    $rutaImagen = $subastaActual->getRutaImagen(); // Usar la imagen actual por defecto
    
    if (isset($_FILES['imagenSubasta']) && $_FILES['imagenSubasta']['error'] === UPLOAD_ERR_OK && $_FILES['imagenSubasta']['size'] > 0) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($_FILES['imagenSubasta']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $extensionesPermitidas)) {
            http_response_code(400);
            echo "El formato de la imagen no es válido. Solo se permiten JPEG, PNG, GIF y WEBP.";
            exit;
        }
        
        // Crear un nombre único para la imagen
        $nombreImagen = uniqid() . '_' . basename($_FILES['imagenSubasta']['name']);
        $directorioDestino = __DIR__ . '/../../fotos/';
        
        // Asegúrate de que el directorio existe
        if (!is_dir($directorioDestino)) {
            if (!mkdir($directorioDestino, 0777, true)) {
                http_response_code(500);
                echo "Error al crear el directorio para las imágenes.";
                exit;
            }
        }
        
        // Ruta completa del archivo
        $rutaDestino = $directorioDestino . $nombreImagen;
        
        if (move_uploaded_file($_FILES['imagenSubasta']['tmp_name'], $rutaDestino)) {
            $rutaImagen = 'fotos/' . $nombreImagen;
        } else {
            http_response_code(500);
            echo "Error al subir la nueva imagen.";
            exit;
        }
    }

    // Crear objeto Subasta con los datos actualizados
    $subastaActualizada = new Subasta(
        $id,
        $nombreSubasta,
        $descripcionSubasta,
        $precio_original,
        $subastaActual->getPrecio_actual(), 
        $_SESSION['userid'],
        $rutaImagen,
        $productoActual->getEstado(),
        $fechaSubasta,
        $horaSubasta
    );

    // Actualizar la subasta en la base de datos
    if ($subastaDAO->actualizarSubasta($subastaActualizada)) {
        http_response_code(200);
        echo "Subasta actualizada correctamente.";
    } else {
        http_response_code(500);
        echo "Error al actualizar la subasta.";
    }
    
    exit;
}
?>