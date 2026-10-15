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
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: ../Php/index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "ferreterianuevo");

    if ($conexion->connect_error) {
        echo "Error de conexión: " . $conexion->connect_error;
        exit();
    }

    $correo_usuario = $_SESSION['correo'];
    $consulta_usuario = "SELECT idUsuario FROM usuario WHERE correo = ?";
    $declaracion_usuario = $conexion->prepare($consulta_usuario);
    $declaracion_usuario->bind_param("s", $correo_usuario);
    $declaracion_usuario->execute();
    $resultado_usuario = $declaracion_usuario->get_result();

    if ($resultado_usuario->num_rows == 0) {
        echo "Error: No se encontró el usuario.";
        exit();
    }

    $fila_usuario = $resultado_usuario->fetch_assoc();
    $usuario_id = $fila_usuario['idUsuario'];

    $productos = json_decode($_POST['productos'], true);

    // Verificar si hay suficiente stock para todos los productos
    foreach ($productos as $producto) {
        $producto_id = $producto['idProducto'];
        $cantidad = $producto['cantidad'];

        // Consultar el stock actual del producto
        $consulta_stock = "SELECT stockProducto, nombreProductos FROM productos WHERE idProducto = ?";
        $declaracion_stock = $conexion->prepare($consulta_stock);
        $declaracion_stock->bind_param("i", $producto_id);
        $declaracion_stock->execute();
        $resultado_stock = $declaracion_stock->get_result();

        if ($resultado_stock->num_rows == 0) {
            echo "Error: No se encontró el producto en el inventario.";
            exit();
        }

        $fila_stock = $resultado_stock->fetch_assoc();
        $stock_disponible = $fila_stock['stockProducto'];
        $nombre_producto = $fila_stock['nombreProductos'];

        // Verificar si la cantidad solicitada excede la cantidad disponible en el stock
        if ($cantidad > $stock_disponible) {
            echo '<div class ="mensajes-alertas">¡Error! No hay suficiente existencia del producto "' . $nombre_producto . '".
                <div class ="mensaje-boton"><a href="../Php/index.php">Aceptar</a>
                </div>
            </div>';
            exit(); // Salir del proceso de verificación
        }

        // Procesar la compra si hay stock disponible
        $fecha = date("Y-m-d H:i:s");

        // Restar la cantidad comprada del inventario
        $consulta_inventario = "UPDATE productos SET stockProducto = stockProducto - ? WHERE idProducto = ?";
        $declaracion_inventario = $conexion->prepare($consulta_inventario);
        $declaracion_inventario->bind_param("ii", $cantidad, $producto_id);
        $declaracion_inventario->execute();

        if ($declaracion_inventario->affected_rows <= 0) {
            echo "Error al restar la cantidad del inventario.";
            $declaracion_inventario->close();
            $conexion->close();
            exit();
        }

        // Insertar la compra en la tabla de compras
        $consulta_compra = "INSERT INTO compras (usuario_id, producto_id, cantidad, fecha) VALUES (?, ?, ?, ?)";
        $declaracion_compra = $conexion->prepare($consulta_compra);
        $declaracion_compra->bind_param("iiis", $usuario_id, $producto_id, $cantidad, $fecha);
        $declaracion_compra->execute();

        if ($declaracion_compra->affected_rows <= 0) {
            echo "Error al procesar la compra.";
            $declaracion_compra->close();
            $conexion->close();
            exit();
        }
    }

    $conexion->close();

    echo '<div class ="mensajes-alertas">¡Compra exitosa! Gracias por tu compra.
        <div class ="mensaje-boton"><a href="../Php/comprasCliente.php">Aceptar</a>
        </div>
    </div>';
} else {
    echo '<div class ="mensajes-alertas">Error: El formulario de compra no se envió correctamente.
        <div class ="mensaje-boton"><a href="../Php/index.php">Aceptar</a>
        </div>
    </div>';
}
?>
</body>
</html>
