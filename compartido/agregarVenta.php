<?php
include "conexion.php";

$response = ['success' => false, 'message' => ''];

if (isset($_POST['guardar'])) {
    // Validación de campos del producto
    $camposProducto = ['id', 'producto', 'precio', 'cantidad', 'descripcion', 'categoria'];
    $camposVaciosProducto = array_filter($camposProducto, function($campo) {
        return empty($_POST[$campo]);
    });

    if (!empty($camposVaciosProducto)) {
        $response['message'] = 'Campos del producto vacíos: ' . implode(', ', $camposVaciosProducto);
    } else {
        // Datos del producto
        $codigoProducto = $_POST['id'];
        $producto = $_POST['producto'];
        $precio_unitario = (float)$_POST['precio']; // Asegurándose de que es un float
        $cantidad = (int)$_POST['cantidad']; // Asegurándose de que es un int
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];

        // Verificar si hay suficientes productos en el inventario
        $queryStock = "SELECT stockProducto FROM productos WHERE codigoProducto = ?";
        $stmtStock = mysqli_prepare($conn, $queryStock);
        mysqli_stmt_bind_param($stmtStock, "s", $codigoProducto);
        mysqli_stmt_execute($stmtStock);
        mysqli_stmt_bind_result($stmtStock, $stockProducto);
        mysqli_stmt_fetch($stmtStock);
        mysqli_stmt_close($stmtStock);

        if ($stockProducto < $cantidad) {
            $response['message'] = 'No hay suficiente cantidad de productos en el inventario.';
        } else {
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

                // Continúa la lógica para insertar datos del cliente...

                $response['success'] = true;
                $response['message'] = '¡Datos guardados exitosamente!';
            } else {
                $response['message'] = '¡Error al agregar producto! ' . mysqli_error($conn);
            }

            mysqli_stmt_close($stmtProducto);
        }
    }
} else {
    $response['message'] = 'No se recibió el formulario correctamente.';
}

echo json_encode($response);
?>
