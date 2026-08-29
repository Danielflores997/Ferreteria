<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/mensajes.css">
    <title>mensaje</title>
</head>
<body>
    
<?php
    include "conexion.php";

    // Verificar si los datos se han enviado
    if(isset($_POST['nombre'], $_POST['apellido'], $_POST['direccion'], $_POST['telefono'], $_POST['correo'], $_POST['motivo'])) {
        // Recoger los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $motivo = $_POST['motivo'];

        // Insertar datos en la base de datos
        $sql = "INSERT INTO peticiones (Nombre, Apellido, Direccion, Telefono, Correo, Motivo)
                VALUES ('$nombre', '$apellido', '$direccion', '$telefono', '$correo', '$motivo')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class ="mensajes-alertas">Datos enviados correctamente.
            <div class ="mensaje-boton"><a href="../Php/pqrs.php">Aceptar</a>
            </div>
        </div>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "";
    }
?>
</body>
</html>