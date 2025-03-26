<?php
class DB {
    protected $db;

    public function __construct($dbname = '../database/database.db') {
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

}
