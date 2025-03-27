<?php
class DB {
    public $db;

    public function __construct($dbname = 'C:\xampp\htdocs\awproyecto\includes\database\database.db') {
        try {
            $this->db = new PDO("sqlite:" . $dbname);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getBD(){
        return $this->db;
    }

}
