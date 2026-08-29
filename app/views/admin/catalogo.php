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
<h2 class="catalogo">Productos</h2>
<section class="contenedor"><div class="contenedor-items">
<?php foreach (($productos ?? []) as $row): ?>
<div class="item">
    <span class="titulo-item"><?= e($row['nombreProductos']) ?></span>
    <img class="img-catalogo" src="<?= e($row['imagen']) ?>" alt="">
    <span class="titulo-item"><?= e($row['descripcionProducto']) ?></span>
    <span class="precio-item">$ <?= money($row['valorProducto']) ?></span>
</div>
<?php endforeach; ?>
</div></section>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
