<?php
include "conexion.php"; // Incluir el archivo de conexión

if (isset($_POST['guardar'])) {
    if (empty($_POST["codigo"]) || empty($_POST["producto"]) || empty($_POST["precio"]) || empty($_POST["cantidad"]) || empty($_POST["descripcion"]) || empty($_POST["categoria"])) {
        echo 'Uno de los campos está vacío';
    } else {
        $codigo = $_POST['codigo'];
        $producto = $_POST['producto'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];

        // Realizar la inserción en la base de datos
        $sql = "INSERT INTO productos (codigoProducto, nombreProductos, valorProducto, stockProducto, descripcionProducto, nombreCategoria) VALUES ('$codigo', '$producto', '$precio', '$cantidad', '$descripcion', '$categoria')";
        if (mysqli_query($conn, $sql)) { // Cambio de $conexion a $conn
            echo 'Nuevo producto agregado correctamente';
        } else {
            echo 'Error al agregar el producto: ' . mysqli_error($conn); // Cambio de $conexion a $conn
        }

        mysqli_close($conn);
    }
}
?>

