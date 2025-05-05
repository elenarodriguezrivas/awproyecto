<?php
require_once '../../database/Connection.php';
require_once '../model/subasta.php';

class SubastaDAO {
    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }

    public function agregarSubasta(Subasta $subasta) : bool {{
        try {
            $sql = "INSERT INTO Subastas (idProducto, fechaSubasta, estado, precio) 
                    VALUES (:idProducto, :fechaSubasta, :estado, :precio)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a variables
            $idProducto = $subasta->getIdProducto();
            $fechaSubasta = $subasta->getfechaSubasta();
            $precio = $subasta->getPrecio();
            $estado = $subasta->getEstado();

            // Pasar las variables a bindParam
            $stmt->bindParam(':idProducto', $nombre, PDO::PARAM_INT);
            $stmt->bindParam(':fechaSubasta', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_INT);

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


    public static function eliminarSubasta($idProducto) {
        $conn = DB::getInstance()->getBD();
        $sql = "DELETE FROM Subastas WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$idProducto]);
    }

    public static function obtenerSubastasPorPropietario($idPropietario) {
        $conn = DB::getInstance()->getBD();
        $sql = "SELECT s.*, p.* FROM Subastas s 
                JOIN Productos p ON s.idProducto = p.id 
                WHERE p.propietario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idPropietario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerProductosEnSubasta () {
        try {
            $sql = "SELECT 
                        s.id AS idSubasta,
                        s.idProducto,
                        s.fechaSubasta,
                        s.estado AS estadoSubasta,
                        s.precio AS precioSubasta,
                        p.nombre,
                        p.descripcion,
                        p.imagen,
                        p.categoria,
                        p.idUsuario
                    FROM 
                        Subastas s
                    INNER JOIN 
                        Productos p ON s.idProducto = p.id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener subastas con información de productos: " . $e->getMessage());
            return false;
        }
    }
}
}
?>
