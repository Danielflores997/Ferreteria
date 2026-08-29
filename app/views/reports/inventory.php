<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
</head>
<body>
    <h1>Reporte de Inventario</h1>

    <?php if (!empty($products)): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['idProducto']); ?></td>
                    <td><?php echo htmlspecialchars($product['nombreProductos']); ?></td>
                    <td><?php echo htmlspecialchars($product['valorProducto']); ?></td>
                    <td><?php echo htmlspecialchars($product['cantidad']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay productos registrados.</p>
    <?php endif; ?>

    <p><a href="../public/admin.php">Volver al panel</a></p>
</body>
</html>
