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
            // Assuming 'rol' is also a column in the 'usuarios' table
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }
}
?>