<?php
include "conexion.php"; 

if (isset($_POST['guardar'])) {
    // Validar campos del producto
    $camposProducto = ['id', 'producto', 'precio', 'cantidad', 'descripcion', 'categoria'];
    $camposVaciosProducto = array_filter($camposProducto, function($campo) {
        return empty($_POST[$campo]);
    });

    if (!empty($camposVaciosProducto)) {
        echo 'Campos del producto vacíos: ' . implode(', ', $camposVaciosProducto);
    } else {
        // Datos del producto
        $codigoProducto = $_POST['id'];
        $producto = $_POST['producto'];
        $precio_unitario = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];

        // Insertar datos del producto
        $sqlProducto = "INSERT INTO ventas (idcodigo, producto, precio_unitario, cantidad, descripcion, Categoria) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtProducto = mysqli_prepare($conn, $sqlProducto);
        mysqli_stmt_bind_param($stmtProducto, "ssddss", $codigoProducto, $producto, $precio_unitario, $cantidad, $descripcion, $categoria);

        if (mysqli_stmt_execute($stmtProducto)) {
            // Actualizar stock del producto en la tabla de productos
            $sqlUpdateStock = "UPDATE productos SET stockProducto = stockProducto - ? WHERE codigoProducto = ?";
            $stmtUpdateStock = mysqli_prepare($conn, $sqlUpdateStock);
            mysqli_stmt_bind_param($stmtUpdateStock, "is", $cantidad, $codigoProducto);
            mysqli_stmt_execute($stmtUpdateStock);
            mysqli_stmt_close($stmtUpdateStock);

            // Datos del cliente
            $camposCliente = ['tipoDocumentoCliente', 'documentoCliente', 'nombresCliente', 'apellidosCliente', 'telefonoCliente', 'direccionCliente', 'estadoCliente'];
            $camposVaciosCliente = array_filter($camposCliente, function($campo) {
                return !isset($_POST[$campo]) || empty($_POST[$campo]);
            });

            // Verificar que los datos requeridos no son nulos
            if (empty($camposVaciosCliente)) {
                // Datos del cliente
                $tipoDocumentoCliente = $_POST['tipoDocumentoCliente'];
                $documentoCliente = $_POST['documentoCliente'];
                $nombresCliente = $_POST['nombresCliente'];
                $apellidosCliente = $_POST['apellidosCliente'];
                $telefonoCliente = $_POST['telefonoCliente'];
                $direccionCliente = $_POST['direccionCliente'];
                $estadoCliente = $_POST['estadoCliente'];

                // Insertar datos del cliente
                $sqlCliente = "INSERT INTO cliente (tipoDocumentoCliente, documentoCliente, nombresCliente, apellidosCliente, telefonoCliente, direccionCliente, estadoCliente) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtCliente = mysqli_prepare($conn, $sqlCliente);
                mysqli_stmt_bind_param($stmtCliente, "sssssss", $tipoDocumentoCliente, $documentoCliente, $nombresCliente, $apellidosCliente, $telefonoCliente, $direccionCliente, $estadoCliente);

                if (mysqli_stmt_execute($stmtCliente)) {
                    echo '<div class ="mensajes-alertas">¡Datos Guardados Exitosamente.
                        <div class ="mensaje-boton"><a href="../compartido/agregarVenta.php">Aceptar</a></div>';
                } else {
                    echo '<div class ="mensajes-alertas">¡Error al Agregar Cliente.
                        <div class ="mensaje-boton"><a href="../compartido/agregarVenta.php">Aceptar</a></div>'. mysqli_error($conn);
                }

                mysqli_stmt_close($stmtCliente);
            } else {
                echo 'Campos del cliente vacíos: ' . implode(', ', $camposVaciosCliente);
            }
        } else {
            echo '<div class ="mensajes-alertas">¡Error al Agregar Producto.
                <div class ="mensaje-boton"><a href="../compartido/agregarVenta.php">Aceptar</a></div>'. mysqli_error($conn);
        }

        mysqli_stmt_close($stmtProducto);
    }
}
?>