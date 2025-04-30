<?php

require_once __DIR__ . '/../config.php';

class DB {
    private static ?DB $instance = null; // Almacena la única instancia de la clase
    private ?PDO $db = null;

    // Constructor privado para evitar instanciación directa
    private function __construct() {
        // Cargar configuración desde config.php
        $host = BD_HOST;
        $dbname = BD_NAME;
        $username = BD_USER;
        $password = BD_PASS;

        $this->initialize(); // Inicializar la conexión a la base de datos
        $this->shutdown(); // Registrar el cierre de la conexión
    }
    private function initialize($host, $dbname, $username, $password){ //aislar la inicialización
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    private function shutdown(){ //aislar el cierre de la conexión al finalizar el script
        register_shutdown_function([$this, 'closeConnection']);
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

    // Método para cerrar la conexión
    public function closeConnection() {
        $this->db = null; // Cerrar la conexión estableciendo el objeto PDO a null (esto se debe a que en la documentacion de PDO al poner el puntero a null automaticamente se libera la conexion y es la ventaja con respecto a sqli)
    }

    // Evitar clonación de la instancia
    private function __clone() {}

}
