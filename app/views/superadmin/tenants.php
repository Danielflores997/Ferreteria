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
    <h1>Gestión de Ferreterías</h1>
    <a href="<?= BASE_URL ?>superadmin/crear">Crear nueva ferretería</a>
    <br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr><th>#</th><th>Nombre</th><th>Slug</th><th>Documento</th><th>Correo</th><th>Teléfono</th><th>Estado</th><th>Acciones</th></tr>
        <?php foreach ($tenants as $i => $t): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($t['nombre']) ?></td>
            <td><?= htmlspecialchars($t['slug']) ?></td>
            <td><?= htmlspecialchars($t['documento'] ?? '-') ?></td>
            <td><?= htmlspecialchars($t['correo'] ?? '-') ?></td>
            <td><?= htmlspecialchars($t['telefono'] ?? '-') ?></td>
            <td><?= htmlspecialchars($t['estado']) ?></td>
            <td>
                <a href="<?= url('superadmin/editar/' . (int)$t['id']) ?>">Editar</a> |
                <form method="post" action="<?= url('superadmin/cambiarEstado/' . (int)$t['id']) ?>" style="display:inline" onsubmit="return confirm('¿Cambiar el estado de esta ferretería?')">
                    <button type="submit">Cambiar estado</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>