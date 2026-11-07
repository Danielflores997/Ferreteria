<?php
defined('BASE_URL') or define('BASE_URL', '/Ferreteria/public');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="<?= asset('css/superadmin.css') ?>">
</head>
<body>
    <h1>Editar Ferretería</h1>
    <form method="post" action="<?= url('superadmin/update/' . (int)$tenant['id']) ?>">
        <label>Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($tenant['nombre'] ?? '') ?>" required></label><br>
        <label>Slug: <input type="text" name="slug" value="<?= htmlspecialchars($tenant['slug'] ?? '') ?>" required></label><br>
        <label>Documento: <input type="text" name="documento" value="<?= htmlspecialchars($tenant['documento'] ?? '') ?>"></label><br>
        <label>Correo: <input type="email" name="correo" value="<?= htmlspecialchars($tenant['correo'] ?? '') ?>"></label><br>
        <label>Teléfono: <input type="text" name="telefono" value="<?= htmlspecialchars($tenant['telefono'] ?? '') ?>"></label><br>
        <label>Dirección: <input type="text" name="direccion" value="<?= htmlspecialchars($tenant['direccion'] ?? '') ?>"></label><br>
        <label>Logo (URL): <input type="text" name="logo" value="<?= htmlspecialchars($tenant['logo'] ?? '') ?>"></label><br>
        <label>Estado:
            <select name="estado">
                <option value="Activo" <?= $tenant['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Inactivo" <?= $tenant['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </label><br><br>
        <button type="submit">Actualizar ferretería</button>
        <br><br>
        <a href="<?= url('superadmin/tenants') ?>">Volver al listado</a>
</body>
</html>