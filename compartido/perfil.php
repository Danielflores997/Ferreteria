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
    <link rel="stylesheet" type="text/css" href="../CSS/perfil.css">
</head>
<body>
    <div class="container">
        <h2>Perfil del Usuario</h1>
        <p><strong>Nombre:</strong> <?php echo $usuario['nombresUsuario'] . ' ' . $usuario['apellidosUsuario']; ?></p>
        <p><strong>Correo:</strong> <?php echo $usuario['correo']; ?></p>
        <p><strong>Tipo de Documento:</strong> <?php echo $usuario['tipoDocumentoUsuario']; ?></p>
        <p><strong>Documento:</strong> <?php echo $usuario['documentopUsuario']; ?></p>

        <!-- Mostrar la clave con un botón de ojito -->
        <p>
            <strong>Clave:</strong>
            <span id="clave" type="password"><?php echo hidePassword($usuario['claveUsuario']); ?></span>
            <button type="button" onclick="togglePassword()">Mostrar/ocultar Clave</button>
        </p>

        <!-- Mostrar el estado del usuario -->
        <p><strong>Estado:</strong> <span id="estado"><?php echo $usuario['estadoUsuario']; ?></span></p>
    </div>

    <script>
        // Función para alternar la visibilidad de la contraseña
        function togglePassword() {
            var passwordField = document.getElementById("clave");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>


