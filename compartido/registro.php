<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/mensajes.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje</title>
</head>
<body>
    

<?php
$mysqli = new mysqli('localhost', 'root', '', 'ferreterianuevo');
if ($mysqli->connect_error) {
    die('Error en la conexión: ' . $mysqli->connect_error);
}

if (isset($_POST['registro'])) {
    // Verificar que todos los campos estén completos
    if (empty($_POST['tipo_documento']) || empty($_POST['documento']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['Correo']) || empty($_POST['Contraseña']) || empty($_POST['Confirmar'])) {
        echo '<div class ="mensajes-alertas">Todos los campos son obligatorios. Por favor, completa todos los campos.
        <div class ="mensaje-boton"><a href="../Php/registroCliente.php">Aceptar</a>
        </div>
    </div>';
exit();
}
    }

    // Verificar que el documento solo contenga números
    if (!is_numeric($_POST['documento'])) {
        echo '<div class ="mensajes-alertas"> El documento solo debe contener números.</div>';
        exit();
    }

    $tipoDocumento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['Correo'];
    $contrasena = $_POST['Contraseña'];
    $confirmarContrasena = $_POST['Confirmar'];

    if ($contrasena !== $confirmarContrasena) {
        echo '<div class ="mensajes-alertas"> Las contraseñas no coinciden. Por favor, inténtalo nuevamente.
        <div class ="mensaje-boton"><a href="../Php/registroCliente.php">Aceptar</a>
        </div>
    </div>';
exit();
    }

    // Verificar si el número de documento ya existe en la base de datos
    $verificarDocumento = "SELECT documentoUsuario FROM usuario WHERE documentoUsuario = '$documento'";
    $resultadoDocumento = $mysqli->query($verificarDocumento);

    if ($resultadoDocumento->num_rows > 0) {
        echo '<div class ="mensajes-alertas">El número de documento ya esta registrado
                <div class ="mensaje-boton"><a href="../Php/registroCliente.php">Aceptar</a>
                </div>
            </div>';
        exit();
    }

    $sql = "INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario)
            VALUES ('$tipoDocumento', '$documento', '$nombre', '$apellido', '$correo', '$contrasena')";

    if ($mysqli->query($sql)) {
        echo '<div class ="mensajes-alertas">¡Bienvenido! Registro exitoso.
        <div class ="mensaje-boton"><a href="../Php/loginCliente.php">Aceptar</a></div>' . $mysqli->error;
    } else {
        echo '<div class ="mensajes-alertas"> Error al registrar el usuario:
        <div class ="mensaje-boton"><a href="../Php/registroCliente.php">Aceptar</a>
        </div>' . $mysqli->error;
    }

$mysqli->close();
?>
</body>
</html>