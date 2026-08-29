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
<h2>Editar cliente</h2>
<?php if (!empty($error)): ?><p class="mensaje-error"><?= e($error) ?></p><?php endif; ?>
<form class="form-admin estrecho" action="<?= url('admin/editarCliente/'.(int)$cliente['idCliente']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$cliente['idCliente'] ?>">
<div class="panel">
    <h5><i class="fas fa-user"></i> Datos del cliente</h5>
    <div class="campos">
        <div class="campo">
            <label for="tipoDocumento">Tipo documento</label>
            <select id="tipoDocumento" name="tipoDocumento">
            <?php foreach (['CC','TI','CE'] as $td): ?>
                <option value="<?= $td ?>" <?= $cliente['tipoDocumentoCliente']===$td?'selected':'' ?>><?= $td ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="campo">
            <label for="identificacion">Identificación</label>
            <input type="text" id="identificacion" name="identificacion" value="<?= e($cliente['documentoCliente']) ?>">
        </div>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= e($cliente['nombresCliente']) ?>">
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" value="<?= e($cliente['apellidosCliente']) ?>">
        </div>
        <div class="campo">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="<?= e($cliente['telefonoCliente']) ?>">
        </div>
        <div class="campo">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="Activo" <?= $cliente['estadoCliente']==='Activo'?'selected':'' ?>>Activo</option>
                <option value="Inactivo" <?= $cliente['estadoCliente']==='Inactivo'?'selected':'' ?>>Inactivo</option>
            </select>
        </div>
        <div class="campo ancho-total">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" value="<?= e($cliente['direccionCliente']) ?>">
        </div>
    </div>
</div>
<div class="acciones">
    <a href="<?= url('admin/usuarios') ?>"><i class="fas fa-arrow-left"></i> Cancelar</a>
    <button type="submit" name="guardar"><i class="fas fa-save"></i> Guardar cambios</button>
</div>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
