<?php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDAO{

    private $db = DB::getBD();

    public function listarUsuarios(): array {
        try {
            $sql = "SELECT * FROM Usuarios";
            $stmt = $this->db->query($sql);

            $usuarios = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $usuarios[] = new Usuario(
                    $row['userid'],
                    $row['contrasena'],
                    $row['email'],
                    $row['nombre'],
                    $row['apellidos'],
                    (int)$row['edad'],
                    $row['rol']
                );
            }
            return $usuarios;
        } catch (PDOException $e) {
            error_log("Error al listar usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function existeUsuario(string $userid): bool {
        try {
            $sql = "SELECT COUNT(*) as count FROM Usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result && $result['count'] > 0);
        } catch (PDOException $e) {
            error_log("Error al verificar existencia de usuario: " . $e->getMessage());
            return false;
        }
    }

    public function agregarUsuario(Usuario $usuario): bool {
        try {
            $sql = "INSERT INTO Usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) 
                    VALUES (:userid, :contrasena, :email, :nombre, :apellidos, :edad, :rol)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':userid', $usuario->getUserid(), PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', password_hash($usuario->getContrasena(), PASSWORD_BCRYPT), PDO::PARAM_STR);
            $stmt->bindValue(':email', $usuario->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':apellidos', $usuario->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':edad', (int)$usuario->getEdad(), PDO::PARAM_INT);
            $stmt->bindValue(':rol', $usuario->getRol(), PDO::PARAM_STR);

            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            error_log("Error al agregar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUsuario(string $userid): ?Usuario {
        try {
            $sql = "SELECT * FROM Usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Usuario(
                    $row['userid'],
                    $row['contrasena'],
                    $row['email'],
                    $row['nombre'],
                    $row['apellidos'],
                    (int)$row['edad'],
                    $row['rol']
                );
            }
            return null;
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return null;
        }
    }

    public function comprobarContrasena(string $userid, string $contrasena): bool {
        try {
            $sql = "SELECT contrasena FROM Usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($contrasena, $row['contrasena'])) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error al comprobar contraseña: " . $e->getMessage());
            return false;
        }
    }
}
?>
