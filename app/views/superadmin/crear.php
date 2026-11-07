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
    <h1>Crear Ferretería</h1>
    <form method="post" action="<?= url('superadmin/store') ?>">
        <label>Nombre: <input type="text" name="nombre" required></label><br>
        <label>Slug (único, ej. mi-ferreteria): <input type="text" name="slug" required></label><br>
        <label>Documento: <input type="text" name="documento"></label><br>
        <label>Correo: <input type="email" name="correo"></label><br>
        <label>Teléfono: <input type="text" name="telefono"></label><br>
        <label>Dirección: <input type="text" name="direccion"></label><br>
        <label>Logo (URL): <input type="text" name="logo"></label><br>
        <label>Estado:
            <select name="estado">
                <option value="Activo" selected>Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </label><br><br>
        <h2>Cuenta administradora</h2>
        <label>Tipo de documento:
            <select name="admin_tipo_documento" required>
                <option value="CC">CC</option>
                <option value="TI">TI</option>
                <option value="CE">CE</option>
            </select>
        </label><br>
        <label>Documento: <input type="text" name="admin_documento" required></label><br>
        <label>Nombres: <input type="text" name="admin_nombres" required></label><br>
        <label>Apellidos: <input type="text" name="admin_apellidos" required></label><br>
        <label>Correo global: <input type="email" name="admin_correo" required></label><br>
        <label>Contraseña (mínimo 12 caracteres):
            <input type="password" name="admin_clave" minlength="12" required autocomplete="new-password">
        </label><br><br>
        <button type="submit">Crear ferretería</button>
        <br><br>
        <a href="<?= url('superadmin/tenants') ?>">Volver al listado</a>
    </form>
</body>
</html>