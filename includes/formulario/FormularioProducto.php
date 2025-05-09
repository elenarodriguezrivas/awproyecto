<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../database/Connection.php';
require_once __DIR__.'/../Producto/model/Producto.php'; 
require_once __DIR__.'/../Producto/sa/registerProductoSA.php';
require_once __DIR__.'/../Producto/dao/ProductoDAO.php';
require_once __DIR__ . '/../Categorias/sa/listarCategoriasSA.php';

/**
 * Formulario para registrar un producto.
 */
class FormularioProducto extends Formulario
{
    private $categorias = [];

    /**
     * Construye el formulario.
     */
    public function __construct()
    {
        parent::__construct('productForm', [
            'urlRedireccion' => RUTA_APP . '/view/perfil_pantalla.php'
        ]);

        $categoriaSA = new listarCategoriasSA();
        $this->categorias = $categoriaSA->listarCategorias();
    }

    /**
     * Genera los campos del formulario.
     */
    protected function generaCamposFormulario()
{

    // Inicio del formulario
    $html = <<<EOF
    <div class="form-group">
        <label for="nombreProducto">Nombre del Producto:</label>
        <input id="nombreProducto" type="text" name="nombreProducto" required class="form-control">
    </div>
    <div class="form-group">
        <label for="descripcionProducto">Descripción del Producto:</label>
        <input id="descripcionProducto" type="text" name="descripcionProducto" required class="form-control">
    </div>
    <div class="form-group">
        <label for="precio">Precio:</label>
        <input id="precio" type="number" step="0.01" name="precio" required class="form-control">
    </div>
    <div class="form-group">
        <label for="categoriaProducto">Categoría del Producto:</label>
        <select id="categoriaProducto" name="categoriaProducto" required class="form-control">
            <option value="">Seleccione una categoría</option>
EOF;

    foreach ($this->categorias as $categoria) {
        $nombre = htmlspecialchars($categoria->getCategoria());
        $html .= "<option value=\"$nombre\">$nombre</option>";
    }    
    
    $html .= <<<EOF
        </select>
    </div>
    <div class="form-group">
        <label for="imagenProducto">Imagen del Producto:</label>
        <input id="imagenProducto" type="file" name="imagenProducto" required class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" class="btn">Registrar Producto</button>
    </div>
EOF;

    return $html;
}

    protected function procesaFormulario(&$datos)
    {
    }
}