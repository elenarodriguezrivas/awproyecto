<?php
require_once './includes/database/Connection.php';
require_once './includes/Usuarios/model/Usuario.php';

class UsuarioDAO extends DB {
    
    public function listarUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $result = $this->query($sql);

        $usuarios = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $usuario = new Usuario(
                $row['userid'],
                $row['contrasena'],
                $row['email'],
                $row['nombre'],
                $row['apellidos'],
                $row['edad'],
                $row['rol']
            );
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }

    public function existeUsuario($userid) {
        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE userid = :userid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }
    
    public function comprobarContrasena($userid, $contrasena) {
        $sql = "SELECT contrasena FROM usuarios WHERE userid = :userid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return password_verify($contrasena, $result['contrasena']);
        } else {
            return false;
        }
    }

    public function agregarUsuario(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) VALUES (:userid, :contrasena, :email, :nombre, :apellidos, :edad, :rol)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userid', $usuario->getUserid(), PDO::PARAM_INT);
        $stmt->bindParam(':contrasena', password_hash($usuario->getContrasena(), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindParam(':email', $usuario->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $usuario->getApellidos(), PDO::PARAM_STR);
        $stmt->bindParam(':edad', $usuario->getEdad(), PDO::PARAM_INT);
        $stmt->bindParam(':rol', $usuario->getRol(), PDO::PARAM_STR);

        return $stmt->execute();
    }

}
?>