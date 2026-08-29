<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>

    <ul>
        <li>Productos: <?php echo htmlspecialchars((string)$totals['productos']); ?></li>
        <li>Usuarios: <?php echo htmlspecialchars((string)$totals['usuarios']); ?></li>
        <li>Proveedores: <?php echo htmlspecialchars((string)$totals['proveedores']); ?></li>
        <li>Ventas: <?php echo htmlspecialchars((string)$totals['ventas']); ?></li>
    </ul>

    <p><a href="../public/admin.php">Volver al panel</a></p>
</body>
</html>
