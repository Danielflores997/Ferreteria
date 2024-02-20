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

if (isset($_POST['guardar'])) {

    // Datos del proveedor
    $nombreProveedor = $_POST['nombreProveedor'];
    $apellidoProveedor = $_POST['apellidoProveedor'];
    $idProveedor = $_POST['idProveedor'];
    $telefonoProveedor = $_POST['telefonoProveedor'];
    $direccionProveedor = $_POST['direccionProveedor'];
    $correoProveedor = $_POST['correoProveedor'];

    // Verificar si el ID del proveedor ya está en uso
    $sqlVerificarID = "SELECT idProveedor FROM proveedor WHERE idProveedor = ?";
    $stmtVerificarID = mysqli_prepare($conn, $sqlVerificarID);
    mysqli_stmt_bind_param($stmtVerificarID, "s", $idProveedor);
    mysqli_stmt_execute($stmtVerificarID);
    mysqli_stmt_store_result($stmtVerificarID);

    if (mysqli_stmt_num_rows($stmtVerificarID) > 0) {
        echo '<div class ="mensajes-alertas">El ID del proveedor ya está en uso.
        <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a>
        </div>
    </div>';
    } else {
        // Insertar datos del proveedor
        $sqlProveedor = "INSERT INTO proveedor (nombreProveedor, apellidoProveedor, idProveedor, telefonoProveedor, direccionProveedor, correoProveedor) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProveedor = mysqli_prepare($conn, $sqlProveedor);
        mysqli_stmt_bind_param($stmtProveedor, "ssssss", $nombreProveedor, $apellidoProveedor, $idProveedor, $telefonoProveedor, $direccionProveedor, $correoProveedor);

        if (!mysqli_stmt_execute($stmtProveedor)) {
            $error = true;
            echo 'Error al agregar el proveedor:' . mysqli_error($conn);
        } else {
            echo '<div class ="mensajes-alertas">Proveedor agregado correctamente.
            <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a>
            </div>';
        }
    }

    // Datos del producto
    $codigo = $_POST['codigo'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $imagen_url = $_POST['imagen'];

    // Verificar si el producto ya existe en la base de datos
    $sqlVerificarProducto = "SELECT codigoProducto FROM productos WHERE codigoProducto = ?";
    $stmtVerificarProducto = mysqli_prepare($conn, $sqlVerificarProducto);
    mysqli_stmt_bind_param($stmtVerificarProducto, "s", $codigo);
    mysqli_stmt_execute($stmtVerificarProducto);
    mysqli_stmt_store_result($stmtVerificarProducto);

    if (mysqli_stmt_num_rows($stmtVerificarProducto) > 0) {
        // Si el producto ya existe, actualiza el stock
        $sqlActualizarStock = "UPDATE productos SET stockProducto = stockProducto + ? WHERE codigoProducto = ?";
        $stmtActualizarStock = mysqli_prepare($conn, $sqlActualizarStock);
        mysqli_stmt_bind_param($stmtActualizarStock, "is", $cantidad, $codigo);
        mysqli_stmt_execute($stmtActualizarStock);

        echo '<div class ="mensajes-alertas">El producto ya existe. Se ha actualizado el stock.
        <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a>
        </div>
    </div>';
    } else {
        // Si el producto no existe, inserta un nuevo registro
        $sqlInsertarProducto = "INSERT INTO productos (codigoProducto, nombreProductos, valorProducto, stockProducto, descripcionProducto, nombreCategoria, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtInsertarProducto = mysqli_prepare($conn, $sqlInsertarProducto);
        mysqli_stmt_bind_param($stmtInsertarProducto, "ssddsss", $codigo, $producto, $precio, $cantidad, $descripcion, $categoria, $imagen_url);

        if (mysqli_stmt_execute($stmtInsertarProducto)) {
            echo '<div class ="mensajes-alertas">Nuevo producto agregado correctamente
            <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a>
            </div>
        </div>';
        } else {
            echo '<div class ="mensajes-alertas">Error al agregar el producto
            <div class ="mensaje-boton"><a href="../Php/inventario.php">Aceptar</a>
            </div>
        </div>'. mysqli_error($conn);
        }
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>
</body>
</html>
