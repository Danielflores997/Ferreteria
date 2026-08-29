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

<h2>Registrar usuario</h2>
<form class="form-admin" action="<?= url('admin/crearUsuario') ?>" method="POST">
<div class="panel">
    <h5><i class="fas fa-user-plus"></i> Nuevo usuario</h5>
    <div class="campos">
        <div class="campo">
            <label for="nuevoTipoDocumento">Tipo documento</label>
            <select id="nuevoTipoDocumento" name="tipoDocumento" required>
                <option value="CC">CC</option><option value="TI">TI</option><option value="CE">CE</option>
            </select>
        </div>
        <div class="campo">
            <label for="nuevoDocumento">Documento</label>
            <input type="text" id="nuevoDocumento" name="documento" required>
        </div>
        <div class="campo">
            <label for="nuevoNombres">Nombres</label>
            <input type="text" id="nuevoNombres" name="nombres" required>
        </div>
        <div class="campo">
            <label for="nuevoApellidos">Apellidos</label>
            <input type="text" id="nuevoApellidos" name="apellidos" required>
        </div>
        <div class="campo">
            <label for="nuevoCorreo">Correo</label>
            <input type="email" id="nuevoCorreo" name="correo" required>
        </div>
        <div class="campo">
            <label for="nuevaClave">Contraseña</label>
            <input type="password" id="nuevaClave" name="clave" required autocomplete="new-password">
        </div>
        <div class="campo">
            <label for="nuevoRol">Rol</label>
            <select id="nuevoRol" name="rol" required>
                <option value="1">Administrador</option>
                <option value="2">Vendedor</option>
                <option value="3" selected>Cliente</option>
            </select>
        </div>
        <div class="campo">
            <label for="nuevoEstado">Estado</label>
            <select id="nuevoEstado" name="estado"><option>Activo</option><option>Inactivo</option></select>
        </div>
    </div>
</div>
<div class="acciones">
    <button type="submit"><i class="fas fa-user-plus"></i> Crear usuario</button>
</div>
</form>

<h2 id="usuarios-titulo-tabla">Usuarios</h2>
<div id="buscar">
<input id="ip-buscar-usuarios" type="text" placeholder="Buscar usuario...">
<button id="buscar-usuarios" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
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
