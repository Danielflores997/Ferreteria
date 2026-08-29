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
<h2>Editar venta</h2>
<form class="form-admin estrecho" action="<?= url('admin/editarVenta/'.(int)$venta['idVenta']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$venta['idVenta'] ?>">
<div class="panel">
    <h5><i class="fas fa-receipt"></i> Datos de la venta</h5>
    <div class="campos">
        <div class="campo">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" value="<?= e($venta['idcodigo']) ?>">
        </div>
        <div class="campo">
            <label for="producto">Producto</label>
            <input type="text" id="producto" name="producto" value="<?= e($venta['producto']) ?>">
        </div>
        <div class="campo">
            <label for="precio">Precio unitario</label>
            <input type="text" id="precio" name="precio" value="<?= e($venta['precio_unitario']) ?>">
        </div>
        <div class="campo">
            <label for="cantidad">Cantidad</label>
            <input type="text" id="cantidad" name="cantidad" value="<?= e($venta['cantidad']) ?>">
        </div>
        <div class="campo">
            <label for="categoria">Categoría</label>
            <input type="text" id="categoria" name="categoria" value="<?= e($venta['Categoria'] ?? $venta['categoria'] ?? '') ?>">
        </div>
        <div class="campo ancho-total">
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" value="<?= e($venta['descripcion']) ?>">
        </div>
    </div>
</div>
<div class="acciones">
    <a href="<?= url('admin/ventas') ?>"><i class="fas fa-arrow-left"></i> Cancelar</a>
    <button type="submit" name="guardar"><i class="fas fa-save"></i> Guardar cambios</button>
</div>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
