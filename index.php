<?php

$tituloPagina = 'Portada';
		
$contenidoPrincipal=<<<EOS
   <section class="presentacion">
        <h2>Transformando el mercado de segunda mano</h2>
        <div class="destacado">
            <p>En MercaSwapp reinventamos la compraventa de tecnología usada con:</p>
            <ul>
                <li>🔄 Sistema de trueque eco-friendly</li>
                <li>⚡ Subastas en tiempo real con pujas ocultas</li>
                <li>🌱 Programa de compensación de huella digital</li>
                <li>🔒 Garantía certificada de autenticidad</li>
            </ul>
        </div>
                        
        <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
        Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
        disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
EOS;

require("comun/plantilla.php");
?>

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