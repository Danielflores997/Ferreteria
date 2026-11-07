<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= asset('css/superadmin.css') ?>">
</head>
<body>
<main class="superadmin superadmin-narrow">
    <header class="superadmin-header">
        <div>
            <p class="eyebrow">Administración de plataforma</p>
            <h1>Editar ferretería</h1>
            <p><?= e($tenant['nombre']) ?></p>
        </div>
        <a class="button button-secondary" href="<?= url('superadmin/tenants') ?>">Volver al listado</a>
    </header>

    <form class="tenant-form" method="post" action="<?= url('superadmin/update/' . (int)$tenant['id']) ?>">
        <section class="panel form-section">
            <h2>Datos de la ferretería</h2>
            <div class="form-grid">
                <label>Nombre
                    <input type="text" name="nombre" maxlength="150" value="<?= e($tenant['nombre'] ?? '') ?>" required>
                </label>
                <label>Slug
                    <input type="text" name="slug" maxlength="160" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" value="<?= e($tenant['slug'] ?? '') ?>" required>
                </label>
                <label>Documento
                    <input type="text" name="documento" maxlength="30" value="<?= e($tenant['documento'] ?? '') ?>">
                </label>
                <label>Correo de contacto
                    <input type="email" name="correo" maxlength="150" value="<?= e($tenant['correo'] ?? '') ?>">
                </label>
                <label>Teléfono
                    <input type="tel" name="telefono" maxlength="30" value="<?= e($tenant['telefono'] ?? '') ?>">
                </label>
                <label>Dirección
                    <input type="text" name="direccion" maxlength="255" value="<?= e($tenant['direccion'] ?? '') ?>">
                </label>
                <label class="form-span">Logo (URL, opcional)
                    <input type="url" name="logo" maxlength="255" value="<?= e($tenant['logo'] ?? '') ?>">
                </label>
                <label>Estado
                    <select name="estado">
                        <option value="Activo" <?= $tenant['estado'] === 'Activo' ? 'selected' : '' ?>>Activa</option>
                        <option value="Inactivo" <?= $tenant['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactiva</option>
                    </select>
                </label>
            </div>
        </section>
        <div class="form-actions">
            <button class="button button-primary" type="submit">Guardar cambios</button>
            <a class="button button-secondary" href="<?= url('superadmin/tenants') ?>">Cancelar</a>
        </div>
    </form>
</main>
</body>
</html>
