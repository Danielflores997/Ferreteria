<?php
// Función para ocultar parte de la contraseña
function hidePassword($password) {
    return str_repeat("*", strlen($password));
}

include "conexion.php"; // Asegúrate de incluir el archivo de conexión

$correo = $_SESSION['correo'];

$conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");

// Consulta para obtener la información del usuario
$consulta = "SELECT * FROM usuario WHERE correo = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

// Comprueba si se encontró el usuario
if (!$usuario) {
    header('Location: loginCliente.php');
    exit;
}

// Ahora puedes mostrar la información del usuario en la página
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Perfil.css">
</head>
<body>
    <div class="container-perfil">
    <div class="container">
        <h2>Perfil del Usuario</h1>
        <p><strong>Nombre:</strong> <?php echo $usuario['nombresUsuario'] . ' ' . $usuario['apellidosUsuario']; ?></p>
        <p><strong>Correo:</strong> <?php echo $usuario['correo']; ?></p>
        <p><strong>Tipo de Documento:</strong> <?php echo $usuario['tipoDocumentoUsuario']; ?></p>
        <p><strong>Documento:</strong> <?php echo $usuario['documentoUsuario']; ?></p>

        <!-- Mostrar el estado del usuario -->
        <p><strong>Estado:</strong> <span id="estado"><?php echo $usuario['estadoUsuario']; ?></span></p>
    </div>
    </div>
</body>
</html>


