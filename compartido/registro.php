<?php
$mysqli = new mysqli('localhost', 'root', '', 'ferreterianuevo');
if ($mysqli->connect_error) {
    die('Error en la conexión: ' . $mysqli->connect_error);
}
echo "";

if (isset($_POST['registro'])) {
    $tipoDocumento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['Correo'];
    $contrasena = $_POST['Contraseña'];
    $confirmarContrasena = $_POST['Confirmar'];

    if ($contrasena !== $confirmarContrasena) {
        echo "Las contraseñas no coinciden. Por favor, inténtalo nuevamente.";
        exit();
    }

    // Verificar si el número de documento ya existe en la base de datos
    $verificarDocumento = "SELECT documentopUsuario FROM usuario WHERE documentopUsuario = '$documento'";
    $resultadoDocumento = $mysqli->query($verificarDocumento);

    if ($resultadoDocumento->num_rows > 0) {
        echo "El número de documento ya está registrado.";
        exit();
    }

    // Aplicar el hash a la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (tipoDocumentoUsuario, documentopUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario)
            VALUES ('$tipoDocumento', '$documento', '$nombre', '$apellido', '$correo', '$contrasena')";

    if ($mysqli->query($sql)) {
        echo 'Registro exitoso. ¡Bienvenido/a! <a href="../Php/index.php">Ferreteria Meisen</a>';
    } else {
        echo "Error al registrar el usuario: " . $mysqli->error;
    }
}
$mysqli->close();
?>

