<?php
require_once '../../database/Connection.php';
require_once '../model/Subasta.php';

class SubastaDAO {
    private $connection;

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    // Inserta una nueva subasta en la base de datos
    public function create(Subasta $subasta) {
        $stmt = $this->connection->prepare("INSERT INTO subastas (idProducto, fechaInicio, fechaFin, precioInicial) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $subasta->getIdProducto(),
            $subasta->getFechaInicio(),
            $subasta->getFechaFin(),
            $subasta->getPrecioInicial()
        ]);
    }

    // Busca una subasta por su id
    public function findById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM subastas WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Subasta(
                $row['idProducto'],
                $row['fechaInicio'],
                $row['fechaFin'],
                $row['precioInicial'],
                $row['id']
            );
        }
        return null;
    }

    public function delete($idSubasta) {
        $stmt = $this->connection->prepare("DELETE FROM subastas WHERE id = ?");
        return $stmt->execute([$idSubasta]);
    }
    
    public function findAll() {
        $stmt = $this->connection->prepare("SELECT * FROM subastas ORDER BY fechaInicio DESC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $subastas = [];
        foreach ($results as $row) {
            $subastas[] = new Subasta(
                $row['idProducto'],
                $row['fechaInicio'],
                $row['fechaFin'],
                $row['precioInicial'],
                $row['id']
            );
        }
        return $subastas;
    }

    public function findByUser($idUsuario) {
        $stmt = $this->connection->prepare("SELECT s.* FROM subastas s JOIN productos p ON s.idProducto = p.id WHERE p.idUsuario = ? ORDER BY s.fechaInicio DESC");
        $stmt->execute([$idUsuario]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $subastas = [];
        foreach ($results as $row) {
            $subastas[] = new Subasta(
                $row['idProducto'],
                $row['fechaInicio'],
                $row['fechaFin'],
                $row['precioInicial'],
                $row['id']
            );
        }
        return $subastas;
    }
    
    public function findByIdAndUser($idSubasta, $idUsuario) {
        $stmt = $this->connection->prepare("SELECT s.* FROM subastas s JOIN productos p ON s.idProducto = p.id WHERE s.id = ? AND p.idUsuario = ?");
        $stmt->execute([$idSubasta, $idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Subasta(
                $row['idProducto'],
                $row['fechaInicio'],
                $row['fechaFin'],
                $row['precioInicial'],
                $row['id']
            );
        }
        return null;
    }
    
}
?>
