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
            <h1>Panel Superadmin</h1>
            <p>Administra las ferreterías, sus administradores y el crecimiento del marketplace.</p>
        </div>
        <nav class="superadmin-actions">
            <a class="button button-primary" href="<?= url('superadmin/crear') ?>">+ Crear ferretería</a>
            <a class="button button-secondary" href="<?= url('superadmin/tenants') ?>">Gestionar ferreterías</a>
            <a class="button button-secondary" href="<?= url('auth/logout') ?>">Cerrar sesión</a>
        </nav>
    </header>

    <section class="stats-grid" aria-label="Resumen de la plataforma">
        <article class="stat-card">
            <span>Ferreterías activas</span>
            <strong><?= (int)$tenantsActivos ?></strong>
        </article>
        <article class="stat-card">
            <span>Total de ferreterías</span>
            <strong><?= count($tenants) ?></strong>
        </article>
        <article class="stat-card">
            <span>Productos publicados</span>
            <strong><?= (int)$totalProductos ?></strong>
        </article>
        <article class="stat-card">
            <span>Ventas registradas</span>
            <strong>$<?= number_format((float)$totalVentas, 0, ',', '.') ?></strong>
        </article>
    </section>

    <section class="panel">
        <div class="section-heading">
            <div>
                <h2>Ferreterías</h2>
                <p>Cada administrador gestiona los productos de su propia ferretería.</p>
            </div>
            <a class="text-link" href="<?= url('superadmin/tenants') ?>">Ver todas</a>
        </div>
        <?php if (empty($tenants)): ?>
            <div class="empty-state">
                <p>Aún no hay ferreterías registradas.</p>
                <a class="button button-primary" href="<?= url('superadmin/crear') ?>">Crear la primera ferretería</a>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Ferretería</th>
                        <th>Administrador(es)</th>
                        <th>Estado</th>
                        <th>Productos</th>
                        <th>Ventas</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_slice($tenants, 0, 8) as $tenant): ?>
                        <tr>
                            <td>
                                <strong><?= e($tenant['nombre']) ?></strong>
                                <span class="subtext"><?= e($tenant['slug']) ?></span>
                            </td>
                            <td><?= e($tenant['administradores'] ?: 'Sin administrador') ?></td>
                            <td><span class="status status-<?= $tenant['estado'] === 'Activo' ? 'active' : 'inactive' ?>"><?= e($tenant['estado']) ?></span></td>
                            <td><?= (int)$tenant['totalProductos'] ?></td>
                            <td>$<?= number_format((float)$tenant['totalVentas'], 0, ',', '.') ?></td>
                            <td><a class="text-link" href="<?= url('superadmin/editar/' . (int)$tenant['id']) ?>">Editar</a></td>
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
