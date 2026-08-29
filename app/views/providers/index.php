<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
</head>
<body>
    <h1>Listado de Proveedores</h1>

    <?php if (!empty($providers)): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
            <?php foreach ($providers as $provider): ?>
                <tr>
                    <td><?php echo htmlspecialchars($provider['idProveedor']); ?></td>
                    <td><?php echo htmlspecialchars($provider['nombreProveedor']); ?></td>
                    <td><?php echo htmlspecialchars($provider['apellidoProveedor']); ?></td>
                    <td><?php echo htmlspecialchars($provider['telefonoProveedor']); ?></td>
                    <td><?php echo htmlspecialchars($provider['correoProveedor']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay proveedores registrados.</p>
    <?php endif; ?>

    <p><a href="../public/admin.php">Volver al panel</a></p>
</body>
</html>
