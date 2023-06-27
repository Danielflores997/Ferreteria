<?php
if (!empty($_POST["registro"])) {
    if (empty($_POST["tipo_documento"]) || empty($_POST["documento"]) || empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["correo"]) || empty($_POST["contraseña"]) || empty($_POST["confirmar"]) || empty($_POST["tratamiento-datos"])) {
        echo 'Uno de los campos está vacío';
    } else {
        $tipoDoc = $_POST["tipo_documento"];
        $documento = $_POST["documento"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $correo = $_POST["correo"];
        $contraseña = $_POST["contraseña"];
        $confirmar = $_POST["confirmar"];
        $tratamiento_datos = $_POST["tratamiento-datos"];
        
        include "conexion.php"; // Incluir el archivo de conexión
        
        // Realizar la inserción en la base de datos
        $sql = "INSERT INTO usuario (tipoDocumentoUsuario, documentopUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario) VALUES ('$tipoDoc', '$documento', '$nombre', '$apellido', '$correo', '$contraseña')";
        
        if (mysqli_query($conn, $sql)) {
            echo 'Usuario registrado correctamente';
        } else {
            echo 'Error al registrar el usuario: ' . mysqli_error($conn);
        }
        
        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
    }
}
?>

