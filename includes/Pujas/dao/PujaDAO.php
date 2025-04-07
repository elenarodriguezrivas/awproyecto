<?php
require_once '../../database/Connection.php';
require_once '../model/Puja.php';

class PujaDAO {
    private $connection;

    public function __construct() {
        $this->connection = Connection::getInstance();
    }

    // Inserta una nueva puja en la base de datos
    public function create(Puja $puja) {
        $stmt = $this->connection->prepare("INSERT INTO pujas (idSubasta, idUsuario, cantidad, fecha) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $puja->getIdSubasta(),
            $puja->getIdUsuario(),
            $puja->getCantidad(),
            $puja->getFecha()
        ]);
    }

    // Devuelve todas las pujas asociadas a una subasta
    public function findBySubasta($idSubasta) {
        $stmt = $this->connection->prepare("SELECT * FROM pujas WHERE idSubasta = ? ORDER BY cantidad DESC");
        $stmt->execute([$idSubasta]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pujas = [];
        foreach ($results as $row) {
            $pujas[] = new Puja(
                $row['idSubasta'], 
                $row['idUsuario'], 
                $row['cantidad'], 
                $row['fecha'], 
                $row['id']
            );
        }
        return $pujas;
    }
    public function delete($idPuja) {
        $stmt = $this->connection->prepare("DELETE FROM pujas WHERE id = ?");
        return $stmt->execute([$idPuja]);
    }

    public function findByUser($idUsuario) {
        $stmt = $this->connection->prepare("SELECT * FROM pujas WHERE idUsuario = ? ORDER BY fecha DESC");
        $stmt->execute([$idUsuario]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pujas = [];
        foreach ($results as $row) {
            $pujas[] = new Puja(
                $row['idSubasta'],
                $row['idUsuario'],
                $row['cantidad'],
                $row['fecha'],
                $row['id']
            );
        }
        return $pujas;
    }

    // Inserta una nueva puja en la base de datos
    public function create(Puja $puja) {
        $stmt = $this->connection->prepare("INSERT INTO pujas (idSubasta, idUsuario, cantidad, fecha) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $puja->getIdSubasta(),
            $puja->getIdUsuario(),
            $puja->getCantidad(),
            $puja->getFecha()
        ]);
    }

    // Devuelve todas las pujas asociadas a una subasta
    public function findBySubasta($idSubasta) {
        $stmt = $this->connection->prepare("SELECT * FROM pujas WHERE idSubasta = ? ORDER BY cantidad DESC");
        $stmt->execute([$idSubasta]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pujas = [];
        foreach ($results as $row) {
            $pujas[] = new Puja(
                $row['idSubasta'], 
                $row['idUsuario'], 
                $row['cantidad'], 
                $row['fecha'], 
                $row['id']
            );
        }
        return $pujas;
    }
    public function delete($idPuja) {
        $stmt = $this->connection->prepare("DELETE FROM pujas WHERE id = ?");
        return $stmt->execute([$idPuja]);
    }

    public function findByUser($idUsuario) {
        $stmt = $this->connection->prepare("SELECT * FROM pujas WHERE idUsuario = ? ORDER BY fecha DESC");
        $stmt->execute([$idUsuario]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pujas = [];
        foreach ($results as $row) {
            $pujas[] = new Puja(
                $row['idSubasta'],
                $row['idUsuario'],
                $row['cantidad'],
                $row['fecha'],
                $row['id']
            );
        }
        return $pujas;
    }
    
    
    
}
?>
