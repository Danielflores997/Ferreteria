<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <?php if (!empty($users)): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['idUsuario']); ?></td>
                    <td><?php echo htmlspecialchars(($user['nombresUsuario'] ?? '') . ' ' . ($user['apellidosUsuario'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars($user['correo']); ?></td>
                    <td><?php echo htmlspecialchars($user['estadoUsuario']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>

    <p><a href="../public/admin.php">Volver al panel</a></p>
</body>
</html>
