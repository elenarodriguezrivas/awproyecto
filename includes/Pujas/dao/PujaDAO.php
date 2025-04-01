<?php
require_once __DIR__ . '/../model/Puja.php';
require_once __DIR__ . '/../../database/Connection.php';

class PujaDAO { /*extiende de la base*/

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }
    
    public function agregarPuja(Puja $puja) : bool { /*Agregar una nueva puja*/
        try {
            $sql = "INSERT INTO Pujas (idProducto, idPujador, precio) 
                    VALUES (:idProducto, :idPujador, :precio)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a variables
            $idProducto = $puja->getidProducto();
            $idPujador = $puja->getidPuja();
            $precio = $puja->getPrecio();

            // Pasar las variables a bindParam
            $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_STR);
            $stmt->bindParam(':idPujador', $idPujador, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error al agregar producto: " . $e->getMessage());
            return false;
        }
    }

    public function listarProductos(): array {
        try {
            $sql = "SELECT * FROM Productos";
            $stmt = $this->db->query($sql);

            $productos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = new Producto(
                    $row['id'],
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['categoriaProducto'],
                    $row['idVendedor'],
                    $row['rutaImagen'],
                    $row['estado']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log("Error al listar productos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerVendedorPorProductoId(int $productoId) : string{
        try {
            $sql = "SELECT idVendedor FROM Productos WHERE id = :productoId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':productoId', $productoId, PDO::PARAM_INT);
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (string)$row['idVendedor'] : null; // Devuelve el ID del vendedor o null si no se encuentra
        } catch (PDOException $e) {
            error_log("Error al obtener el vendedor por ID de producto: " . $e->getMessage());
            return "";
        }
    }

    public function listarMisProductos(string $userid): array {
        try {
            $sql = "SELECT * FROM Productos WHERE idVendedor = :idVendedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idVendedor', $userid, PDO::PARAM_STR);
            $stmt->execute();

            $productos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = new Producto(
                    $row['id'],
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['categoriaProducto'],
                    $row['idVendedor'],
                    $row['rutaImagen'],
                    $row['estado']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log("Error al listar productos del usuario con ID $userid: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarProducto($idProducto, $idVendedor) {//eliminamos el producto con el nombre indicado solo si lo elimina el vendedor
        try {
            $sql = "DELETE FROM Productos WHERE id = :id AND idVendedor = :idVendedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $idProducto, PDO::PARAM_INT);
            $stmt->bindValue(':idVendedor', $idVendedor, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (object) ['message' => 'Producto eliminado correctamente'];
            } else {
                return (object) ['message' => 'No se ha encontrado el producto'];
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return $e;
        }
    }

    public function obtenerProductoPorId(string $id): ?Producto {/*buscar un producto en concreto por su id*/
        try {
            $sql = "SELECT * FROM Productos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
    
            // Si el producto se encuentra, crear y devolver el objeto Producto
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                // Suponiendo que tienes una clase Producto que se puede instanciar con estos datos
                return new Producto(
                    $row['id'],
                    $row['nombreProducto'],
                    $row['descripcionProducto'],
                    $row['precio'],
                    $row['categoriaProducto'],
                    $row['idVendedor'],
                    $row['rutaImagen'],
                    $row['estado']
                );
            }
            return null; // Si no se encuentra el producto, devolver null
        } catch (PDOException $e) {
            error_log("Error al obtener producto por id: " . $e->getMessage());
            return null;
        }
    }
    

    public function buscarProductosPorCategoria($categoria): array { /*listar productos por categoría*/
        $productosCat = [];
        $conexion = $this->db;

        if ($conexion) {
            $sql = "SELECT * FROM Productos WHERE categoriaProducto = :categoria";

            try {
                $consulta = $conexion->prepare($sql);
                $consulta->bindParam(':categoria', $categoria, PDO::PARAM_STR);
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultados as $row) {
                    $productosCat[] = new Producto(
                        $row['id'],
                        $row['nombreProducto'],
                        $row['descripcionProducto'],
                        $row['precio'],
                        $row['categoriaProducto'],
                        $row['fechaRegistroProducto'],
                        $row['idVendedor'],
                        $row['estado']
                    );
                }
            } catch (PDOException $e) {
                error_log("Error al buscar productos por categoría: " . $e->getMessage());
            }
        }

        return $productosCat;
    }

    public function venta($id) : bool {
        try {
            $sql = "UPDATE Productos SET estado = 'vendido' WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result && $stmt->rowCount() > 0; // Devuelve true si se actualizó al menos una fila
        } catch (PDOException $e) {
            error_log("Error al actualizar el estado del producto a 'vendido': " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUltimoIdProducto(): ?int {
        try {
            $sql = "SELECT id FROM Productos ORDER BY id DESC LIMIT 1";
            $stmt = $this->db->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (int)$row['id'] : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el último ID del producto: " . $e->getMessage());
            return null;
        }
    }

    public function actualizarProducto(Producto $producto): bool {
        try {
            $sql = "UPDATE Productos 
                    SET nombreProducto = :nombreProducto, 
                        descripcionProducto = :descripcionProducto, 
                        precio = :precio, 
                        categoriaProducto = :categoriaProducto, 
                        idVendedor = :idVendedor, 
                        rutaImagen = :rutaImagen, 
                        estado = :estado 
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores del objeto Producto a los parámetros
            $stmt->bindParam(':id', $producto->getId(), PDO::PARAM_INT);
            $stmt->bindParam(':nombreProducto', $producto->getNombreProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':descripcionProducto', $producto->getDescripcionProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':precio', $producto->getPrecio(), PDO::PARAM_STR);
            $stmt->bindParam(':categoriaProducto', $producto->getCategoriaProducto(), PDO::PARAM_STR);
            $stmt->bindParam(':idVendedor', $producto->getIdVendedor(), PDO::PARAM_INT);
            $stmt->bindParam(':rutaImagen', $producto->getRutaImagen(), PDO::PARAM_STR);
            $stmt->bindParam(':estado', $producto->getEstado(), PDO::PARAM_STR);

            $result = $stmt->execute();

            return $result && $stmt->rowCount() > 0; // Devuelve true si se actualizó al menos una fila
        } catch (PDOException $e) {
            error_log("Error al actualizar el producto: " . $e->getMessage());
            return false;
        }
    }
}
?>
