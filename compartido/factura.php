<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Facturas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tabla de Facturas</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha de Factura</th>
                <th>Subtotal</th>
                <th>Impuesto</th>
                <th>Valor Total</th>
                <th>ID de Cliente</th>
                <th>ID de Usuario</th>
                <th>ID de Pedido</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí puedes agregar filas de datos con PHP -->
            <tr>
                <td>2023-09-21</td>
                <td>100.00</td>
                <td>18.00</td>
                <td>118.00</td>
                <td>101</td>
                <td>201</td>
                <td>301</td>
                <td>Ver</td>
                
            </tr>
            <!-- Agrega más filas según tus datos -->
        </tbody>
    </table>
</body>
</html>
<?php
include "conexion.php";
echo 'error';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibe los datos de los productos y el ID de usuario por POST
$usuario_idUsuario = $_POST['usuario_idUsuario'];
$productos = json_decode($_POST['productos'],true); // Suponemos que se envían como un array de productos

// Crear un nuevo pedido
$fechaPedido = date("Y-m-d");
$cliente_idCliente = $usuario_idUsuario; // Suponemos que el cliente es el mismo que el usuario en este ejemplo

$sqlPedido = "INSERT INTO pedido (fechaPedido, cliente_idCliente) VALUES ('$fechaPedido', '$cliente_idCliente')";

if ($conn->query($sqlPedido) === TRUE) {
    $pedido_idPedido = $conn->insert_id; // Obtener el ID del pedido recién creado

    // Crear una nueva factura
    $fechaFactura = date("Y-m-d");
    $subtotalfactura = 0; // Inicializamos el subtotal a cero

    // Insertar la factura en la tabla 'factura'
    $sqlFactura = "INSERT INTO factura (fechaFactura, subtotalfactura, impuesto, valorTotalFactura, cliente_idCliente, usuario_idUsuario, pedido_idPedido) 
                   VALUES ('$fechaFactura', '$subtotalfactura', 0, 0, '$cliente_idCliente', '$usuario_idUsuario', '$pedido_idPedido')";

    if ($conn->query($sqlFactura) === TRUE) {
        $pedido_idFactura = $conn->insert_id; // Obtener el ID del pedido recién creado

        // Iterar a través de los productos y agregarlos a la factura
        foreach ($productos as $producto) {
            $producto_idProducto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $valorProductoVenta = $producto['precio'];
            $totalDetalle = $cantidad * $valorProductoVenta;
            $subtotalfactura += $totalDetalle;

            // Insertar el producto en la tabla 'detallefactura'
            $sqlDetalleFactura = "INSERT INTO detallefactura (factura_idFactura, productos_idProducto, cantidad, valorProductoVenta, totalDetalle)
                                  VALUES ('$pedido_idFactura', '$producto_idProducto', '$cantidad', '$valorProductoVenta', '$totalDetalle')";

           $conn->query($sqlDetalleFactura);
        }

        // Actualizar el subtotal y el valor total de la factura
        $valorTotalFactura = $subtotalfactura;

        $sqlActualizarFactura = "UPDATE factura SET subtotalfactura = '$subtotalfactura', valorTotalFactura = '$valorTotalFactura' WHERE pedido_idPedido = '$pedido_idPedido'";

        $conn->query($sqlActualizarFactura);

        echo "Pedido, factura y productos agregados con éxito.";
    } else {
        echo "Error al crear la factura: " . $conn->error;
    }
} else {
    echo "Error al crear el pedido: " . $conn->error;
}

$conn->close();

}
