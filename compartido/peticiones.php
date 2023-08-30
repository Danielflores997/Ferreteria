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
            echo "Datos enviados correctamente.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "";
    }
?>
