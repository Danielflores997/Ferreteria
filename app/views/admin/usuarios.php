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
<h4 id="usuarios-titulo-tabla">Usuarios</h4>
<div id="buscar">
<button id="buscar-usuarios"><i class="fa-solid fa-magnifying-glass"></i></button>
<input id="ip-buscar-usuarios" type="text">
</div>
<div id="usuarios-tabla"><table>
<tr>
<th id="celda-principal">Tipo Documento</th>
<th id="celda-principal">Identificación</th>
<th id="celda-principal">Nombre</th>
<th id="celda-principal">Apellido</th>
<th id="celda-principal">Correo</th>
<th id="celda-principal">Estado</th>
<th id="celda-principal">Rol</th>
<th id="celda-principal">Acciones</th>
</tr>
<?php foreach (($usuarios ?? []) as $row): ?>
<tr>
<td><?= e($row['tipoDocumentoUsuario']) ?></td>
<td><?= e($row['documentoUsuario']) ?></td>
<td><?= e($row['nombresUsuario']) ?></td>
<td><?= e($row['apellidosUsuario']) ?></td>
<td><?= e($row['correo']) ?></td>
<td><?= e($row['estadoUsuario']) ?></td>
<td><?= e($row['rol_idRol']) ?></td>
<td class="acciones">
<a href="<?= url('admin/editarUsuario/'.$row['idUsuario']) ?>"><i class="fas fa-edit"></i></a>
<form action="<?= url('admin/eliminarUsuario') ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar usuario?');">
<input type="hidden" name="id" value="<?= (int)$row['idUsuario'] ?>">
<button type="submit"><i class="fas fa-trash"></i></button>
</form>
</td></tr>
<?php endforeach; ?>
</table></div>

<div class="clientes-tabla">
<h4 id="clientes-titulo-tabla">Clientes</h4>
<div id="buscar">
<button id="buscar-clientes"><i class="fa-solid fa-magnifying-glass"></i></button>
<input id="ip-buscar-clientes" type="text">
</div>
<div id="clientes-tabla"><table>
<tr>
<th id="celda-principal">Tipo Documento</th>
<th id="celda-principal">Identificación</th>
<th id="celda-principal">Nombre</th>
<th id="celda-principal">Apellido</th>
<th id="celda-principal">Teléfono</th>
<th id="celda-principal">Dirección</th>
<th id="celda-principal">Estado</th>
<th id="celda-principal">Acciones</th>
</tr>
<?php foreach (($clientes ?? []) as $row): ?>
<tr>
<td><?= e($row['tipoDocumentoCliente']) ?></td>
<td><?= e($row['documentoCliente']) ?></td>
<td><?= e($row['nombresCliente']) ?></td>
<td><?= e($row['apellidosCliente']) ?></td>
<td><?= e($row['telefonoCliente']) ?></td>
<td><?= e($row['direccionCliente']) ?></td>
<td><?= e($row['estadoCliente']) ?></td>
<td class="acciones">
<a href="<?= url('admin/editarCliente/'.$row['idCliente']) ?>"><i class="fas fa-edit"></i></a>
<form action="<?= url('admin/eliminarCliente') ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar cliente?');">
<input type="hidden" name="id" value="<?= (int)$row['idCliente'] ?>">
<button type="submit"><i class="fas fa-trash"></i></button>
</form>
</td></tr>
<?php endforeach; ?>
</table></div>
</div>
<script>
$(function(){
  $('#buscar-usuarios').click(function(){
    $.post('<?= url('admin/buscarUsuario') ?>',{searchTerm:$('#ip-buscar-usuarios').val()},function(h){ $('#usuarios-tabla table').html(h); });
  });
  $('#buscar-clientes').click(function(){
    $.post('<?= url('admin/buscarCliente') ?>',{searchTerm:$('#ip-buscar-clientes').val()},function(h){ $('#clientes-tabla table').html(h); });
  });
});
</script>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
