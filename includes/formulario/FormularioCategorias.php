<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Categorias/dao/CategoriaDAO.php';
require_once __DIR__.'/../Categorias/model/Categoria.php';

class FormularioCategorias extends Formulario
{
    private $categoria;

    public function __construct($productoId)
    {
        parent::__construct('formModificarProducto');
        
        $productoDAO = new ProductoDAO();
        $this->producto = $productoDAO->obtenerProductoPorId($productoId);
        
        if (!$this->producto) {
            header("Location: micatalogo_pantalla.php?error=Producto no encontrado");
            exit;
        }
        
        // Verificar que el usuario actual es el propietario del producto
        if ($this->producto->getIdVendedor() !== $_SESSION['userid']) {
            header("Location: micatalogo_pantalla.php?error=No tienes permiso para modificar este producto");
            exit;
        }
    }

    protected function generaCamposFormulario()
    {
        // Obtener datos directamente del producto
        $nombreCategoria = $this->categoria->getCategoria();

        $html = <<<EOF
        <div class="form-group">
            <label for="nombreProducto">Nombre del Producto:</label>
            <input id="nombreProducto" type="text" name="nombreProducto" value="$nombreProducto" required class="form-control">
        </div>
        <div class="form-group">
            <label for="descripcionProducto">Descripción del Producto:</label>
            <input id="descripcionProducto" type="text" name="descripcionProducto" value="$descripcionProducto" required class="form-control">
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input id="precio" type="number" step="0.01" name="precio" value="$precio" required class="form-control">
        </div>
        <div class="form-group">
            <label for="categoriaProducto">Categoría del Producto:</label>
            <select id="categoriaProducto" name="categoriaProducto" required class="form-control">
                <option value="">Seleccione una categoría</option>
EOF;

        // Obtener conexión
        $conn = DB::getInstance()->getBD();

        // Consultar todas las categorías desde la BD
        $query = "SELECT nombre FROM Categorias";
        $result = $conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $nombreCategoria = htmlspecialchars($row['nombre']);
                $html .= "<option value=\"$nombreCategoria\">$nombreCategoria</option>";
            }
        } else {
            $html .= "<option value=\"\">Error al cargar categorías</option>";
        }

        // Generar las opciones con la opción seleccionada
        foreach ($result as $valor => $texto) {
            $selected = ($categoriaProducto == $valor) ? 'selected' : '';
            $html .= "<option value=\"$valor\" $selected>$texto</option>";
        }

        $html .= <<<EOF
            </select>
        </div>
        <div class="form-group">
            <label>Imagen actual:</label>
            <img src="../$rutaImagen" alt="Imagen actual" style="max-width: 200px; max-height: 200px; display: block; margin-bottom: 10px;">
        </div>
        <div class="form-group">
            <label for="imagenProducto">Nueva imagen (opcional):</label>
            <input id="imagenProducto" type="file" name="imagenProducto" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-blue">Guardar Cambios</button>
            <button type="button" onclick="window.location.href='micatalogo_pantalla.php'" class="btn btn-secondary">Cancelar</button>
        </div>
        <div id="message" class="message"></div>
EOF;
        return $html;
    }
}