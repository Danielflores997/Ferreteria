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
<h2>Proveedores</h2>
<div id="buscar">
<input id="ip-buscar-Proveedor" type="text" placeholder="Buscar proveedor...">
<button id="buscar-Proveedor" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
</div>
<div id="Proveedor-tabla"><table>
<tr>
<th id="celda-principal">Identificación</th>
<th id="celda-principal">Nombre</th>
<th id="celda-principal">Apellido</th>
<th id="celda-principal">Teléfono</th>
<th id="celda-principal">Dirección</th>
<th id="celda-principal">Correo</th>
<th id="celda-principal">Acciones</th>
</tr>
<?php foreach (($proveedores ?? []) as $row): ?>
<tr>
<td><?= e($row['idProveedor']) ?></td>
<td><?= e($row['nombreProveedor']) ?></td>
<td><?= e($row['apellidoProveedor']) ?></td>
<td><?= e($row['telefonoProveedor']) ?></td>
<td><?= e($row['direccionProveedor']) ?></td>
<td><?= e($row['correoProveedor']) ?></td>
<td class="acciones">
<a href="<?= url('admin/editarProveedor/'.$row['idProveedor']) ?>"><i class="fas fa-edit"></i></a>
<form action="<?= url('admin/eliminarProveedor') ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar proveedor?');">
<input type="hidden" name="id" value="<?= (int)$row['idProveedor'] ?>">
<button type="submit"><i class="fas fa-trash"></i></button>
</form>
</td></tr>
<?php endforeach; ?>
</table></div>
<script>
$('#buscar-Proveedor').click(function(){
  $.post('<?= url('admin/buscarProveedor') ?>',{searchTerm:$('#ip-buscar-Proveedor').val()},function(h){ $('#Proveedor-tabla table').html(h); });
});
</script>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
