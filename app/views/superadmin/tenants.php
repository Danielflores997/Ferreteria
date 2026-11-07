<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= asset('css/superadmin.css') ?>">
</head>
<body>
<main class="superadmin">
    <header class="superadmin-header">
        <div>
            <p class="eyebrow">Administración de plataforma</p>
            <h1>Gestión de ferreterías</h1>
            <p>Consulta sus administradores, actividad y estado.</p>
        </div>
        <nav class="superadmin-actions">
            <a class="button button-primary" href="<?= url('superadmin/crear') ?>">+ Crear ferretería</a>
            <a class="button button-secondary" href="<?= url('superadmin/index') ?>">Volver al panel</a>
        </nav>
    </header>

    <?php if (!empty($mensaje)): ?>
        <div class="notice notice-success" role="status"><?= e($mensaje) ?></div>
    <?php endif; ?>

    <section class="panel">
        <form class="search-form" method="get" action="<?= url('superadmin/tenants') ?>">
            <label for="tenant-search">Buscar por ferretería, slug o administrador</label>
            <div>
                <input id="tenant-search" type="search" name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Ej. Ferretería Central">
                <button class="button button-secondary" type="submit">Buscar</button>
                <?php if (!empty($_GET['q'])): ?>
                    <a class="text-link" href="<?= url('superadmin/tenants') ?>">Limpiar</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($tenants)): ?>
            <div class="empty-state">
                <p>No se encontraron ferreterías.</p>
                <a class="button button-primary" href="<?= url('superadmin/crear') ?>">Crear ferretería</a>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Ferretería</th>
                        <th>Administradores</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Productos</th>
                        <th>Ventas</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($tenants as $tenant): ?>
                        <tr>
                            <td>
                                <strong><?= e($tenant['nombre']) ?></strong>
                                <span class="subtext"><?= e($tenant['slug']) ?></span>
                            </td>
                            <td><?= e($tenant['administradores'] ?: 'Sin administrador') ?></td>
                            <td>
                                <span><?= e($tenant['correo'] ?: '-') ?></span>
                                <span class="subtext"><?= e($tenant['telefono'] ?: '-') ?></span>
                            </td>
                            <td><span class="status status-<?= $tenant['estado'] === 'Activo' ? 'active' : 'inactive' ?>"><?= e($tenant['estado']) ?></span></td>
                            <td><?= (int)$tenant['totalProductos'] ?></td>
                            <td>$<?= number_format((float)$tenant['totalVentas'], 0, ',', '.') ?></td>
                            <td class="row-actions">
                                <a class="text-link" href="<?= url('superadmin/editar/' . (int)$tenant['id']) ?>">Editar</a>
                                <form method="post" action="<?= url('superadmin/cambiarEstado/' . (int)$tenant['id']) ?>" onsubmit="return confirm('¿Cambiar el estado de esta ferretería?')">
                                    <button class="button button-small button-secondary" type="submit"><?= $tenant['estado'] === 'Activo' ? 'Desactivar' : 'Activar' ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
