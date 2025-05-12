<?php
require_once __DIR__ . '/../model/Categoria.php';
require_once __DIR__ . '/../../database/Connection.php';

class CategoriaDAO { /*extiende de la base*/

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }
    
    public function agregarCategoria(Categoria $categoria) : bool { /*Agregar una nueva categoria*/
        try {
            $sql = "INSERT INTO Categorias (nombre) 
                    VALUES (:nombre)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a variables
            $nombreCategoria = $categoria->getCategoria();

            // Pasar las variables a bindParam
            $stmt->bindParam(':nombre', $nombreCategoria, PDO::PARAM_STR);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error al agregar categoria: " . $e->getMessage());
            return false;
        }
    }

    public function listarCategorias(): array {
        try {
            $sql = "SELECT * FROM Categorias";
            $stmt = $this->db->query($sql);
            error_log("Consulta ejecutada correctamente"); // Debug

            $categorias = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categorias[] = new Categoria(
                    $row['nombre'] 
                );
            }
            return $categorias;
        } catch (PDOException $e) {
            error_log("Error al listar categorias: " . $e->getMessage());
            return [];
        }
    }

    // Método para comprobar si una categoría está asociada a algún producto
    public function tieneProductosAsociados($nombreCategoria) {
        try {
            $sql = "SELECT COUNT(*) FROM Productos WHERE categoriaProducto = :nombre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombre', $nombreCategoria, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();  // Devuelve el número de productos asociados
            return $count > 0;  // Si hay más de 0 productos, devuelve true
        } catch (PDOException $e) {
            error_log("Error al verificar productos asociados a la categoría: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarCategoria($nombreCategoria) { //eliminamos la categoria con el nombre indicado 

        // Comprobar si hay productos asociados a la categoría
        if ($this->tieneProductosAsociados($nombreCategoria)) {
            return (object) ['message' => 'No se puede eliminar la categoría porque está asociada a productos.'];
        }

        try {
            $sql = "DELETE FROM Categorias WHERE nombre = :nombre";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombre', $nombreCategoria, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (object) ['message' => 'Categoria eliminada correctamente'];
            } else {
                return (object) ['message' => 'No se ha encontrado la categoria'];
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar categoria: " . $e->getMessage());
            return $e;
        }
    }

}
?>
