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
<form method="post" action="<?= url('admin/peticiones') ?>">
<div class="contenedor-tabla-peticiones">
<h2>Peticiones</h2>
<?php if (empty($peticiones)): ?>
<p>No se encontraron resultados.</p>
<?php else: ?>
<table border="1" width="100%">
<tr><th>Nombre</th><th>Apellido</th><th>Dirección</th><th>Teléfono</th><th>Correo</th><th>Motivo</th><th>Contestado</th></tr>
<?php foreach ($peticiones as $row): ?>
<tr>
<td><?= e($row['Nombre']) ?></td>
<td><?= e($row['Apellido']) ?></td>
<td><?= e($row['Direccion']) ?></td>
<td><?= e($row['Telefono']) ?></td>
<td><?= e($row['Correo']) ?></td>
<td><?= e($row['Motivo']) ?></td>
<td>
<select name="estado[<?= e($row['Correo']) ?>]">
<option value="No" <?= ($row['Estado']??'')==='No'?'selected':'' ?>>No</option>
<option value="Si" <?= ($row['Estado']??'')==='Si'?'selected':'' ?>>Sí</option>
</select>
</td>
</tr>
<?php endforeach; ?>
</table>
<button type="submit">Guardar estado</button>
<?php endif; ?>
</div>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
