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
<h2>Catálogo de productos</h2>
<div class="catalogo-grid">
<?php if (empty($productos)): ?>
<p class="tabla-vacia">No hay productos registrados.</p>
<?php else: foreach (($productos ?? []) as $row): ?>
<div class="producto-card">
    <img src="<?= e($row['imagen']) ?>" alt="<?= e($row['nombreProductos']) ?>">
    <strong><?= e($row['nombreProductos']) ?></strong>
    <span class="desc"><?= e($row['descripcionProducto']) ?></span>
    <span class="precio">$ <?= money($row['valorProducto']) ?></span>
</div>
<?php endforeach; endif; ?>
</div>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
