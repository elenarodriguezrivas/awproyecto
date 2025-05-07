<?php
require_once __DIR__ . '/../model/Puja.php';
require_once __DIR__ . '/../../database/Connection.php';

class PujaDAO { /*extiende de la base*/

    private $db;

    public function __construct() {
        $this->db = DB::getInstance()->getBD();
    }
    
    public function agregarPuja(Puja $puja) : bool { 
        try {
            $sql = "INSERT INTO Pujas (idSubasta, idPujador, precio) 
                    VALUES (:idSubasta, :idPujador, :precio)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a variables
            $idSubasta = $puja->getIdSubasta();
            $idPujador = $puja->getIdPujador();
            $precio = $producto->getPrecio();

            // Pasar las variables a bindParam
            $stmt->bindValue(':idSubasta', $id, PDO::PARAM_INT);
            $stmt->bindValue(':idPujador', $id, PDO::PARAM_STR);
            $stmt->bindValue(':precio', $precio, PDO::PARAM_STR);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error al agregar puja: " . $e->getMessage());
            return false;
        }
    }

    public function listarMisPujas(string $userid): array {
        try {
            $sql = "SELECT * FROM Pujas WHERE idPujador = :idPujador";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPujador', $userid, PDO::PARAM_STR);
            $stmt->execute();

            $pujas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pujas[] = new Puja(
                    $row['idSubasta'],
                    $row['idPujador'],
                    $row['precio']
                );
            }
            return $pujas;
        } catch (PDOException $e) {
            error_log("Error al listar pujas del usuario con ID $userid: " . $e->getMessage());
            return [];
        }
    }

    public function eliminarPuja($idSubasta, $idPujador) {
        try {
            $sql = "DELETE FROM Pujas WHERE idSubasta = :idSubasta AND idPujador = :idPujador";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idSubasta', $idSubasta, PDO::PARAM_INT);
            $stmt->bindValue(':idPujador', $idPujador, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return (object) ['message' => 'Puja eliminada correctamente'];
            } else {
                return (object) ['message' => 'No se ha encontrado la puja'];
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar puja: " . $e->getMessage());
            return $e;
        }
    }

    public function actualizarPuja(Puja $puja): bool {
        try {
            $sql = "UPDATE Pujas
                    SET idSubasta = :idSubasta, 
                        idPujador = :idPujador, 
                        precio = :precio 
                    WHERE idSubasta = :idSubasta AND idPujador = :idPujador";     
            $stmt = $this->db->prepare($sql);
    
            $idSubasta = $puja->getIdSubasta();
            $idPujador = $puja->getIdPujador();
            $precio = $puja->getPrecio();
    
            $stmt->bindValue(':idSubasta', $id, PDO::PARAM_INT);
            $stmt->bindValue(':idPujador', $id, PDO::PARAM_STR);
            $stmt->bindValue(':precio', $precio, PDO::PARAM_STR);
    
            $result = $stmt->execute();
    
            return $result && $stmt->rowCount() > 0; // Devuelve true si se actualizó al menos una fila
        } catch (PDOException $e) {
            error_log("Error al actualizar la puja/no ha hecho ninguna actualizacion: " . $e->getMessage());
            return false;
        }
    }
}
?>

