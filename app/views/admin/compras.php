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
<h2>Compras Carrito</h2>
<form class="barra-buscar" method="GET" action="<?= url('admin/compras') ?>">
<input type="text" name="buscar" value="<?= e($buscar ?? '') ?>" placeholder="Buscar compras...">
<button type="submit"><i class="fas fa-search"></i></button>
</form>
<div class="tabla-scroll">
<table>
<thead>
<tr><th>ID</th><th>Usuario</th><th>Documento</th><th>Producto</th><th>Cantidad</th><th>Fecha</th></tr>
</thead>
<tbody>
<?php if (empty($compras)): ?>
<tr><td colspan="6" class="tabla-vacia">No hay compras registradas.</td></tr>
<?php else: foreach ($compras as $fila): ?>
<tr>
<td><?= e($fila['id']) ?></td>
<td><?= e($fila['usuario']) ?></td>
<td><?= e($fila['numeroDocumento']) ?></td>
<td><?= e($fila['producto']) ?></td>
<td><?= e($fila['cantidad']) ?></td>
<td><?= e($fila['fecha']) ?></td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</div>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
