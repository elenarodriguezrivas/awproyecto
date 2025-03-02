<?php
require_once __DIR__ . '/../database/Connection.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDAO extends DB {

    /**
     * Obtiene todos los usuarios de la base de datos.
     *
     * @return array<Usuario>
     */
    public function listarUsuarios(): array {
        try {
            $sql = "SELECT * FROM usuarios";
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

    /**
     * Verifica si un usuario ya existe en la base de datos.
     *
     * @param string $userid
     * @return bool
     */
    public function existeUsuario(string $userid): bool {
        try {
            $sql = "SELECT COUNT(*) as count FROM usuarios WHERE userid = :userid";
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

    /**
     * Comprueba si la contraseña de un usuario es correcta.
     *
     * @param string $userid
     * @param string $contrasena
     * @return bool
     */
    public function comprobarContrasena(string $userid, string $contrasena): bool {
        try {
            $sql = "SELECT contrasena FROM usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result && password_verify($contrasena, $result['contrasena']));
        } catch (PDOException $e) {
            error_log("Error al comprobar contraseña: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Agrega un nuevo usuario a la base de datos.
     *
     * @param Usuario $usuario
     * @return bool
     */
    public function agregarUsuario(Usuario $usuario): bool {
        try {
            $sql = "INSERT INTO usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) 
                    VALUES (:userid, :contrasena, :email, :nombre, :apellidos, :edad, :rol)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':userid', $usuario->getUserid(), PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', password_hash($usuario->getContrasena(), PASSWORD_BCRYPT), PDO::PARAM_STR);
            $stmt->bindValue(':email', $usuario->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
            $stmt->bindValue(':apellidos', $usuario->getApellidos(), PDO::PARAM_STR);
            $stmt->bindValue(':edad', (int)$usuario->getEdad(), PDO::PARAM_INT);
            $stmt->bindValue(':rol', $usuario->getRol(), PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar usuario: " . $e->getMessage());
            return false;
        }
    }
}
?>
