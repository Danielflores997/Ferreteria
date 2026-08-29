<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title ?? 'Admin') ?></title>
</head>
<body>
<div class="encabezado">
    <header>
        <div class="titulo"><h1>FERRETERIA MEISSEN</h1></div>
        <div class="logo"><img src="<?= asset('imagenes/ferreteria.jpeg') ?>" alt="logo"></div>
    </header>
    <nav class="navbar"><div class="lista">
        <button class="btn-login"><a class="btn-login" href="<?= url('auth/logout') ?>">Cerrar Sesión</a></button>
    </div></nav>
</div>
<div id="contenedor">
<?php require APP_PATH . '/views/partials/menu_lateral.php'; ?>
<div class="admin-main">
<h2>Editar proveedor</h2>
<form class="form-admin estrecho" action="<?= url('admin/editarProveedor/'.(int)$proveedor['idProveedor']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$proveedor['idProveedor'] ?>">
<div class="panel">
    <h5><i class="fas fa-truck"></i> Datos del proveedor</h5>
    <div class="campos">
        <div class="campo">
            <label for="nombreProveedor">Nombre</label>
            <input type="text" id="nombreProveedor" name="nombreProveedor" value="<?= e($proveedor['nombreProveedor']) ?>">
        </div>
        <div class="campo">
            <label for="apellidoProveedor">Apellido</label>
            <input type="text" id="apellidoProveedor" name="apellidoProveedor" value="<?= e($proveedor['apellidoProveedor']) ?>">
        </div>
        <div class="campo">
            <label for="telefonoProveedor">Teléfono</label>
            <input type="text" id="telefonoProveedor" name="telefonoProveedor" value="<?= e($proveedor['telefonoProveedor']) ?>">
        </div>
        <div class="campo">
            <label for="correoProveedor">Correo</label>
            <input type="text" id="correoProveedor" name="correoProveedor" value="<?= e($proveedor['correoProveedor']) ?>">
        </div>
        <div class="campo ancho-total">
            <label for="direccionProveedor">Dirección</label>
            <input type="text" id="direccionProveedor" name="direccionProveedor" value="<?= e($proveedor['direccionProveedor']) ?>">
        </div>
    </div>
</div>
<div class="acciones">
    <a href="<?= url('admin/proveedores') ?>"><i class="fas fa-arrow-left"></i> Cancelar</a>
    <button type="submit" name="guardar"><i class="fas fa-save"></i> Guardar cambios</button>
</div>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
