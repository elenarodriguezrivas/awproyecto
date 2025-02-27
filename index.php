<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="./styles/estilos.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <div id="usuarios">
        <?php 
        require_once './includes/Usuarios/dao/listar.php'; 
        $usuarioDAO = new UsuarioDAO();
        $usuarios = $usuarioDAO->listarUsuarios();
        foreach ($usuarios as $usuario) {
            echo "<p>{$usuario->getNombre()} {$usuario->getApellidos()} ({$usuario->getEmail()})</p>";
        }
        ?>
    </div>
</body>
</html>