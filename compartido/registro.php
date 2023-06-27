<?php
$mysqli = new mysqli('localhost', 'root', '', 'ferreterianuevo');
if ($mysqli->connect_error) {
    die('Error en la conexión: ' . $mysqli->connect_error);
}
echo "Conexión satisfactoria";

if (isset($_POST['registro'])) {
    $tipoDocumento = $_POST['tipo_documento'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['Correo'];
    $contrasena = $_POST['Contraseña'];

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
