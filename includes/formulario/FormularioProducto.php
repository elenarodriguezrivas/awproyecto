<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php';
require_once __DIR__.'/../Producto/model/Producto.php'; 
require_once __DIR__.'/../Producto/sa/registerProductoSA.php';
require_once __DIR__.'/../Producto/dao/ProductoDAO.php';

/**
 * Formulario para registrar un producto.
 */
class FormularioProducto extends Formulario
{
    /**
     * Construye el formulario.
     */
    public function __construct()
    {
        parent::__construct('formProducto', [
            'urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php',
            'enctype' => 'multipart/form-data'
        ]);
    }

    /**
     * Genera los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
{
    $nombreProducto = $datos['nombreProducto'] ?? '';
    $descripcionProducto = $datos['descripcionProducto'] ?? '';
    $precio = $datos['precio'] ?? '';
    $categoriaProducto = $datos['categoriaProducto'] ?? '';

    $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores, 'errores-generales');
    $erroresCampos = self::generaErroresCampos(['nombreProducto', 'descripcionProducto', 'precio', 'categoriaProducto', 'imagenProducto'], $this->errores, 'span', ['class' => 'error']);

    // Inicio del formulario
    $html = <<<EOF
    <div class="form-group">
        <label for="nombreProducto">Nombre del Producto:</label>
        <input id="nombreProducto" type="text" name="nombreProducto" value="$nombreProducto" required class="form-control">
        {$erroresCampos['nombreProducto']}
    </div>
    <div class="form-group">
        <label for="descripcionProducto">Descripción del Producto:</label>
        <input id="descripcionProducto" type="text" name="descripcionProducto" value="$descripcionProducto" required class="form-control">
        {$erroresCampos['descripcionProducto']}
    </div>
    <div class="form-group">
        <label for="precio">Precio:</label>
        <input id="precio" type="number" step="0.01" name="precio" value="$precio" required class="form-control">
        {$erroresCampos['precio']}
    </div>
    <div class="form-group">
        <label for="categoriaProducto">Categoría del Producto:</label>
        <select id="categoriaProducto" name="categoriaProducto" required class="form-control">
            <option value="">Seleccione una categoría</option>
EOF;

    // Definir las opciones de categoría
    $opciones = [
        'computadora' => 'Computadora',
        'auriculares' => 'Auriculares',
        'juegos' => 'Juegos',
        'ratón' => 'Ratón',
        'teclado' => 'Teclado',
        'pantalla' => 'Pantalla',
        'impresora' => 'Impresora',
        'altavoces' => 'Altavoces'
    ];

    // Generar las opciones con la lógica de selección fuera de la cadena heredoc
    foreach ($opciones as $valor => $texto) {
        $selected = ($categoriaProducto == $valor) ? 'selected' : '';
        $html .= "<option value=\"$valor\" $selected>$texto</option>";
    }

    $html .= <<<EOF
        </select>
        {$erroresCampos['categoriaProducto']}
    </div>
    <div class="form-group">
        <label for="imagenProducto">Imagen del Producto:</label>
        <input id="imagenProducto" type="file" name="imagenProducto" required class="form-control">
        {$erroresCampos['imagenProducto']}
    </div>
    $htmlErroresGlobales
    <div class="form-group">
        <button type="submit" class="btn">Registrar Producto</button>
    </div>
EOF;

    return $html;
}

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        // Validar nombre del producto
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        if (!$nombreProducto || empty($nombreProducto)) {
            $this->errores['nombreProducto'] = 'El nombre del producto no puede estar vacío';
        }

        // Validar descripción del producto
        $descripcionProducto = trim($datos['descripcionProducto'] ?? '');
        if (!$descripcionProducto || empty($descripcionProducto)) {
            $this->errores['descripcionProducto'] = 'La descripción del producto no puede estar vacía';
        }

        // Validar precio
        $precio = trim($datos['precio'] ?? '');
        if (!is_numeric($precio) || $precio <= 0) {
            $this->errores['precio'] = 'El precio debe ser un número mayor a 0';
        }

        // Validar categoría del producto
        $categoriaProducto = trim($datos['categoriaProducto'] ?? '');
        if (!$categoriaProducto || empty($categoriaProducto)) {
            $this->errores['categoriaProducto'] = 'Debe seleccionar una categoría';
        }

        // Validar imagen del producto
        if (!isset($_FILES['imagenProducto']) || $_FILES['imagenProducto']['error'] !== UPLOAD_ERR_OK) {
            $this->errores['imagenProducto'] = 'Debe subir una imagen válida';
        } else {
            $imagenProducto = $_FILES['imagenProducto'];
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($imagenProducto['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $extensionesPermitidas)) {
                $this->errores['imagenProducto'] = 'El formato de la imagen no es válido. Solo se permiten JPEG, PNG, GIF y WEBP.';
            } else {
                // Procesar la imagen
                $nombreImagen = uniqid() . "_" . basename($imagenProducto['name']);
                $directorioFotos = RAIZ_APP . '/../fotos/';

                // Asegúrate de que el directorio existe
                if (!is_dir($directorioFotos)) {
                    if (!mkdir($directorioFotos, 0777, true)) {
                        $this->errores['imagenProducto'] = 'No se pudo crear el directorio para guardar las imágenes.';
                        return;
                    }
                    chmod($directorioFotos, 0777); // Asegura permisos de escritura
                }

                // Ruta completa del archivo
                $rutaDestino = $directorioFotos . $nombreImagen;

                if (!move_uploaded_file($imagenProducto['tmp_name'], $rutaDestino)) {
                    $this->errores['imagenProducto'] = 'Error al subir la imagen al servidor.';
                    return;
                }
            }
        }

        // Si no hay errores, insertar en la base de datos
        if (count($this->errores) === 0) {
            $rutaRelativa = 'fotos/' . $nombreImagen;
            $producto = new Producto(
                null,
                $nombreProducto,
                $descripcionProducto,
                $precio,
                $categoriaProducto,
                $_SESSION['userid'],
                $rutaRelativa,
                'enVenta'
            );

            $registerProductoSA = new RegisterProductoSA();
            if (!$registerProductoSA->agregarProducto($producto)) {
                $this->errores[] = 'Error al registrar el producto en la base de datos.';
            }
        }
    }
}