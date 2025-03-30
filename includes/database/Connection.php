<?php

require_once __DIR__ . '/../config.php';

class DB {
    private static ?DB $instance = null; // Almacena la única instancia de la clase
    private PDO $db;

    // Constructor privado para evitar instanciación directa
    private function __construct() {
        $host = BD_HOST;
        $dbname = BD_NAME;
        $username = BD_USER;
        $password = BD_PASS;
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método estático para obtener la única instancia de la clase
    public static function getInstance(): DB {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para ejecutar consultas
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Método para obtener la conexión PDO
    public function getBD(): PDO {
        return $this->db;
    }

    // Evitar clonación de la instancia
    private function __clone() {}

}
