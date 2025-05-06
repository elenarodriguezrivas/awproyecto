<?php
require_once __DIR__ . '/../model/Subasta.php';
require_once __DIR__ . '/../../database/Connection.php';

class SubastaDAO { /*extiende de la base*/

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }
    
    public function agregarSubasta(Subasta $subasta) : bool { /*Agregar una nueva subasta*/
        try {
            $sql = "INSERT INTO Subastas (nombre, descripcion, precio_original, precio_actual, idVendedor, rutaImagen, estado, fechaSubasta, horaSubasta) 
                    VALUES (:nombre, :descripcion, :precio_original, :precio_actual, :idVendedor, :rutaImagen, :estado, :fechaSubasta, :horaSubasta)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a variables
            $nombre = $subasta->getNombreSubasta();
            $descripcion = $subasta->getDescripcionSubasta();
            $precio_original = $subasta->getPrecio_original();
            $precio_actual= $subasta->getPrecio_actual();
            $idVendedor = $subasta->getIdVendedor();
            $rutaImagen = $subasta->getRutaImagen();
            $estado = $subasta->getEstado();
            $fechaSubasta = $subasta->getFechaSubasta();
            $horaSubasta = $subasta->getHoraSubasta();

            // Pasar las variables a bindParam
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':precio_original', $precio_original, PDO::PARAM_INT);
            $stmt->bindParam(':precio_actual', $precio_actual, PDO::PARAM_INT);
            $stmt->bindParam(':idVendedor', $idVendedor, PDO::PARAM_STR);
            $stmt->bindParam(':rutaImagen', $rutaImagen, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':fechaSubasta', $fechaSubasta, PDO::PARAM_STR);
            $stmt->bindParam(':horaSubasta', $horaSubasta, PDO::PARAM_STR);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error al agregar subasta: " . $e->getMessage());
            return false;
        }
    }

    public function listarSubastas(): array {
        try {
            $sql = "SELECT * FROM Subastas";
            $stmt = $this->db->query($sql);

            $subastas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subastas[] = new Subasta(
                    $row['id'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio_original'],
                    $row['precio_actual'],
                    $row['idVendedor'],
                    $row['rutaImagen'],
                    $row['estado'],
                    $row['fechaSubasta'],
                    $row['horaSubasta']
                );
            }
            return $subastas;
        } catch (PDOException $e) {
            error_log("Error al listar subastas: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerVendedorPorSubastaId(int $subastaId) : string{
        try {
            $sql = "SELECT idVendedor FROM Subastas WHERE id = :subastaId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':subastaId', $subastaId, PDO::PARAM_INT);
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (string)$row['idVendedor'] : null; // Devuelve el ID del vendedor o null si no se encuentra
        } catch (PDOException $e) {
            error_log("Error al obtener el vendedor por ID de subasta: " . $e->getMessage());
            return "";
        }
    }

    public function listarMisSubastas(string $userid): array {
        try {
            $sql = "SELECT * FROM Subastas WHERE idVendedor = :idVendedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idVendedor', $userid, PDO::PARAM_STR);
            $stmt->execute();

            $subastas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subastas[] = new Subasta(
                    $row['id'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio_original'],
                    $row['precio_actual'],
                    $row['idVendedor'],
                    $row['rutaImagen'],
                    $row['estado'],
                    $row['fechaSubasta'],
                    $row['horaSubasta']
                );
            }
            return $subastas;
        } catch (PDOException $e) {
            error_log("Error al listar subastas del usuario con ID $userid: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarSubasta($idSubasta, $idVendedor) {//eliminamos el producto con el nombre indicado solo si lo elimina el vendedor
        try {
            $sql = "DELETE FROM Subastas WHERE id = :id AND idVendedor = :idVendedor";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $idSubasta, PDO::PARAM_INT);
            $stmt->bindValue(':idVendedor', $idVendedor, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (object) ['message' => 'Subasta eliminada correctamente'];
            } else {
                return (object) ['message' => 'No se ha encontrado la subasta'];
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar subasta: " . $e->getMessage());
            return $e;
        }
    }

    public function obtenerSubastaPorId(string $id): ?Producto {/*buscar una subasta en concreto por su id*/
        try {
            $sql = "SELECT * FROM Subastas WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
    
            // Si la subasta se encuentra, crear y devolver el objeto subasta
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Subasta(
                    $row['id'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio_original'],
                    $row['precio_actual'],
                    $row['idVendedor'],
                    $row['rutaImagen'],
                    $row['estado'],
                    $row['fechaSubasta'],
                    $row['horaSubasta']
                );
            }
            return null; // Si no se encuentra la subasta, devolver null
        } catch (PDOException $e) {
            error_log("Error al obtener subasta por id: " . $e->getMessage());
            return null;
        }
    }

    /*public function venta($id) : bool {
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
    }*/

    public function obtenerUltimoIdSubasta(): ?int {
        try {
            $sql = "SELECT id FROM Subastas ORDER BY id DESC LIMIT 1";
            $stmt = $this->db->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? (int)$row['id'] : null;
        } catch (PDOException $e) {
            error_log("Error al obtener el último ID de subasta: " . $e->getMessage());
            return null;
        }
    }

    public function actualizarSubasta(Subasta $subasta): bool {
        try {
            $sql = "UPDATE Subastas 
                    SET nombre = :nombre, 
                        descripcion = :descripcion, 
                        precio_original = :precio_original,
                        precio_actual = :precio_actual, 
                        idVendedor = :idVendedor, 
                        rutaImagen = :rutaImagen, 
                        estado = :estado,
                        fechaSubasta = :fechaSubasta,
                        horaSubasta = :horaSubasta
                    WHERE id = :id";
    
            $stmt = $this->db->prepare($sql);
    
            // Asignar los valores a variables
            $nombreSubasta = $subasta->getNombreSubasta();
            $descripcionSubasta = $subasta->getDescripcionSubasta();
            $precio_original = $subasta->getPrecio_original();
            $precio_actual= $subasta->getPrecio_actual();
            $idVendedor = $subasta->getIdVendedor();
            $rutaImagen = $subasta->getRutaImagen();
            $estado = $subasta->getEstado();
            $fechaSubasta = $subasta->getFechaSubasta();
            $horaSubasta = $subasta->getHoraSubasta();

            // Pasar las variables a bindParam
            $stmt->bindParam(':nombre', $nombreSubasta, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcionSubasta, PDO::PARAM_STR);
            $stmt->bindParam(':precio_original', $precio_original, PDO::PARAM_INT);
            $stmt->bindParam(':precio_actual', $precio_actual, PDO::PARAM_INT);
            $stmt->bindParam(':idVendedor', $idVendedor, PDO::PARAM_STR);
            $stmt->bindParam(':rutaImagen', $rutaImagen, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':fechaSubasta', $fechaSubasta, PDO::PARAM_STR);
            $stmt->bindParam(':horaSubasta', $horaSubasta, PDO::PARAM_STR);
    
            $result = $stmt->execute();
    
            return $result && $stmt->rowCount() > 0; // Devuelve true si se actualizó al menos una fila
        } catch (PDOException $e) {
            error_log("Error al actualizar la subasta/no ha hecho ninguna actualizacion: " . $e->getMessage());
            return false;
        }
    }
}
?>
