<?php
include "conexion.php";

$correo = $_SESSION['correo'];

$conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");

$consulta = "SELECT * FROM usuario WHERE correo = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

if (!$usuario) {
    header('Location: loginCliente.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Perfil.css">
</head>
<body>
    <div class="container-perfil">
        <div class="container">
            <h2>Perfil del Usuario</h2>
            <p><strong>Nombre:</strong> <?php echo $usuario['nombresUsuario'] . ' ' . $usuario['apellidosUsuario']; ?></p>
            <p><strong>Correo:</strong> <?php echo $usuario['correo']; ?></p>
            <p><strong>Tipo de Documento:</strong> <?php echo $usuario['tipoDocumentoUsuario']; ?></p>
            <p><strong>Documento:</strong> <?php echo $usuario['documentoUsuario']; ?></p>
            <p><strong>Estado:</strong> <span id="estado"><?php echo $usuario['estadoUsuario']; ?></span></p>
            <form action="../compartido/actualizarFotoPerfil.php" method="POST">
                <label for="imagen">Cambiar foto de perfil:</label>
                <input type="url" id="imagen" name="foto" placeholder="Enlace de la imagen">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
    <style>
    </style>
</body>
</html>