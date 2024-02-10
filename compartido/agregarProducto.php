<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/mensajes.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar</title>
</head>
<body>
    
<?php
include "conexion.php";

if (isset($_POST['guardar'])) {
    // Validar y convertir idProveedor a entero
    $idProveedor = isset($_POST['idProveedor']) ? intval($_POST['idProveedor']) : 0;

    // Verificar si idProveedor es un número entero positivo
    if ($idProveedor > 0 && is_numeric($_POST['idProveedor'])) {
        // Datos del proveedor
        $nombreProveedor = $_POST['nombreProveedor'];
        $apellidoProveedor = $_POST['apellidoProveedor'];
        $telefonoProveedor = $_POST['telefonoProveedor'];
        $direccionProveedor = $_POST['direccionProveedor'];
        $correoProveedor = $_POST['correoProveedor'];

        // Insertar datos del proveedor
        $sqlProveedor = "INSERT INTO proveedor (nombreProveedor, apellidoProveedor, idProveedor, telefonoProveedor, direccionProveedor, correoProveedor) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProveedor = mysqli_prepare($conn, $sqlProveedor);
        mysqli_stmt_bind_param($stmtProveedor, "ssssss", $nombreProveedor, $apellidoProveedor, $idProveedor, $telefonoProveedor, $direccionProveedor, $correoProveedor);

        if (!mysqli_stmt_execute($stmtProveedor)) {
            $error = true;
            echo '<div class ="mensajes-alertas">¡Error al agregar el proveedor.
            <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a></div>' . mysqli_error($conn);
        }

        // Resto del código...

        // Cerrar las declaraciones preparadas
        mysqli_stmt_close($stmtProveedor);
        mysqli_stmt_close($stmt);

        // Cerrar la conexión
        mysqli_close($conn);
    } else {
        echo '<div class ="mensajes-alertas">¡Error: El dato que ingresaste en la casilla ID Proveedor no es Valido.
        <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a></div>';
    }
}
?>
</body>
</html>
