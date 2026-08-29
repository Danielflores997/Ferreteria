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
<div id="contenedor" style="display:flex">
<?php require APP_PATH . '/views/partials/menu_lateral.php'; ?>
<div class="inventario" style="flex:1;padding:1rem">
<h4>Editar Venta</h4>
<form action="<?= url('admin/editarVenta/'.(int)$venta['idVenta']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$venta['idVenta'] ?>">
<label>Código</label><input name="codigo" value="<?= e($venta['idcodigo']) ?>">
<label>Producto</label><input name="producto" value="<?= e($venta['producto']) ?>">
<label>Precio</label><input name="precio" value="<?= e($venta['precio_unitario']) ?>">
<label>Cantidad</label><input name="cantidad" value="<?= e($venta['cantidad']) ?>">
<label>Descripción</label><input name="descripcion" value="<?= e($venta['descripcion']) ?>">
<label>Categoría</label><input name="categoria" value="<?= e($venta['Categoria'] ?? $venta['categoria'] ?? '') ?>">
<button type="submit" name="guardar">Guardar</button>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
