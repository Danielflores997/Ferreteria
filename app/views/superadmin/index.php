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
    <h1>Panel Superadmin</h1>
    <p>Bienvenido al gestor multi-tenant de Ferreteria Marketplace.</p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr><th>Ferretería</th><th>Slug</th><th>Estado</th><th>Productos</th><th>Ventas</th></tr>
        <?php foreach ($tenants as $t): ?>
        <tr>
            <td><?= htmlspecialchars($t['nombre']) ?></td>
            <td><?= htmlspecialchars($t['slug']) ?></td>
            <td><?= htmlspecialchars($t['estado']) ?></td>
            <td><?= isset($productCounts[$t['id']]) ? $productCounts[$t['id']] : 0 ?></td>
            <td>$<?= number_format($ventasTotales[$t['id']] ?? 0, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="<?= BASE_URL ?>superadmin/tenants">Gestionar ferreterías</a></p>
</body>
</html>