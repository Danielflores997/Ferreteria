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
            <p class="eyebrow">Nueva tienda en el marketplace</p>
            <h1>Crear ferretería</h1>
            <p>Registra la tienda y su primer administrador. Ambos se guardan juntos.</p>
        </div>
        <a class="button button-secondary" href="<?= url('superadmin/tenants') ?>">Volver</a>
    </header>

    <?php if (!empty($mensaje)): ?>
        <div class="notice notice-error" role="alert"><?= e($mensaje) ?></div>
    <?php endif; ?>

    <form class="tenant-form" method="post" action="<?= url('superadmin/store') ?>">
        <section class="panel form-section">
            <h2>Datos de la ferretería</h2>
            <div class="form-grid">
                <label>Nombre de la ferretería
                    <input type="text" name="nombre" maxlength="150" value="<?= e($formData['nombre'] ?? '') ?>" required>
                </label>
                <label>Slug
                    <input type="text" name="slug" maxlength="160" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" value="<?= e($formData['slug'] ?? '') ?>" placeholder="ferreteria-central" required>
                    <small>Solo minúsculas, números y guiones; debe ser único.</small>
                </label>
                <label>Documento
                    <input type="text" name="documento" maxlength="30" value="<?= e($formData['documento'] ?? '') ?>">
                </label>
                <label>Correo de contacto
                    <input type="email" name="correo" maxlength="150" value="<?= e($formData['correo'] ?? '') ?>">
                </label>
                <label>Teléfono
                    <input type="tel" name="telefono" maxlength="30" value="<?= e($formData['telefono'] ?? '') ?>">
                </label>
                <label>Dirección
                    <input type="text" name="direccion" maxlength="255" value="<?= e($formData['direccion'] ?? '') ?>">
                </label>
                <label class="form-span">Logo (URL, opcional)
                    <input type="url" name="logo" maxlength="255" value="<?= e($formData['logo'] ?? '') ?>">
                </label>
                <label>Estado
                    <select name="estado">
                        <option value="Activo" <?= ($formData['estado'] ?? 'Activo') === 'Activo' ? 'selected' : '' ?>>Activa</option>
                        <option value="Inactivo" <?= ($formData['estado'] ?? '') === 'Inactivo' ? 'selected' : '' ?>>Inactiva</option>
                    </select>
                </label>
            </div>
        </section>

        <section class="panel form-section">
            <h2>Administrador de esta ferretería</h2>
            <p class="form-help">Esta cuenta tendrá rol Administrador y quedará vinculada a esta tienda. Su correo debe ser único en la plataforma.</p>
            <div class="form-grid">
                <label>Tipo de documento
                    <select name="admin_tipo_documento" required>
                        <?php foreach (['CC', 'TI', 'CE'] as $tipo): ?>
                            <option value="<?= $tipo ?>" <?= ($formData['admin_tipo_documento'] ?? 'CC') === $tipo ? 'selected' : '' ?>><?= $tipo ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Número de documento
                    <input type="text" name="admin_documento" inputmode="numeric" pattern="[0-9]+" maxlength="20" value="<?= e($formData['admin_documento'] ?? '') ?>" required>
                </label>
                <label>Nombres
                    <input type="text" name="admin_nombres" maxlength="100" value="<?= e($formData['admin_nombres'] ?? '') ?>" required>
                </label>
                <label>Apellidos
                    <input type="text" name="admin_apellidos" maxlength="100" value="<?= e($formData['admin_apellidos'] ?? '') ?>" required>
                </label>
                <label>Correo de acceso
                    <input type="email" name="admin_correo" maxlength="150" value="<?= e($formData['admin_correo'] ?? '') ?>" required>
                </label>
                <label>Contraseña inicial
                    <input type="password" name="admin_clave" minlength="12" autocomplete="new-password" required>
                    <small>Mínimo 12 caracteres. Se almacenará protegida.</small>
                </label>
            </div>
        </section>

        <div class="form-actions">
            <button class="button button-primary" type="submit">Crear ferretería y administrador</button>
            <a class="button button-secondary" href="<?= url('superadmin/tenants') ?>">Cancelar</a>
        </div>
    </form>
</main>
</body>
</html>
