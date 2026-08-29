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
<?php if (!empty($mensaje)): ?><p class="mensajes-alertas"><?= e($mensaje) ?></p><?php endif; ?>
<h4 id="titulo-tabla">Datos Proveedor / Agregar Productos</h4>
<form id="formulario-venta" action="<?= url('admin/inventario') ?>" method="POST">
<div class="datos-proveedor">
    <label>Documento Proveedor</label>
    <input type="text" id="idProveedor" name="idProveedor" required>
    <label>Nombre</label><input type="text" id="nombreProveedor" name="nombreProveedor" required>
    <label>Apellido</label><input type="text" id="apellidoProveedor" name="apellidoProveedor" required>
    <label>Teléfono</label><input type="text" id="telefonoProveedor" name="telefonoProveedor" required>
    <label>Dirección</label><input type="text" id="direccionProveedor" name="direccionProveedor" required>
    <label>Correo</label><input type="text" id="correoProveedor" name="correoProveedor" required>
</div>
<div id="contenidoDos">
    <label>Último código</label>
    <input type="text" value="<?= e($ultimoCodigo ?? '') ?>" readonly>
    <label>Código</label><input type="text" name="codigo" required>
    <label>Producto</label><input type="text" name="producto" required>
    <label>Precio UNI</label><input type="text" name="precio" required>
    <label>Cantidad</label><input type="text" name="cantidad" required>
    <label>Descripción</label><input type="text" name="descripcion" required>
    <label>Categoría</label>
    <select name="categoria" required>
        <?php foreach (($categorias ?? []) as $c): ?>
            <option value="<?= e($c['idCategoria']) ?>"><?= e($c['nombreCategoria']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Imagen (ruta/URL)</label><input type="text" name="imagen">
</div>
<div id="conten-botones">
    <button id="btn-venta" type="submit" name="guardar"><i class="fas fa-save"></i> Guardar</button>
    <a id="btn-generar" href="<?= url('admin/reporteInventario') ?>"><i class="fas fa-file-alt"></i> Reporte CSV</a>
</div>
</form>

<h4 id="titulo-tabla">INVENTARIO</h4>
<div id="buscar">
    <button id="buscar-productos"><i class="fas fa-search"></i></button>
    <input id="ip-buscar-productos" type="text">
</div>
<div id="tabla">
<table>
<tr>
<th class="celda-principal">Código</th>
<th class="celda-principal">Producto</th>
<th class="celda-principal">Precio</th>
<th class="celda-principal">Cantidad</th>
<th class="celda-principal">Descripción</th>
<th class="celda-principal">Categoría</th>
<th class="celda-principal">Acciones</th>
</tr>
<?php foreach (($productos ?? []) as $row): ?>
<tr>
<td><?= e($row['codigoProducto']) ?></td>
<td><?= e($row['nombreProductos']) ?></td>
<td><?= e($row['valorProducto']) ?></td>
<td><?= e($row['stockProducto']) ?></td>
<td><?= e($row['descripcionProducto']) ?></td>
<td><?= e($row['nombreCategoria']) ?></td>
<td class="acciones">
    <a href="<?= url('admin/editarProducto/'.$row['idProducto']) ?>"><i class="fas fa-edit"></i></a>
    <form action="<?= url('admin/eliminarProducto') ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar producto?');">
        <input type="hidden" name="id" value="<?= (int)$row['idProducto'] ?>">
        <button type="submit"><i class="fas fa-trash"></i></button>
    </form>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
<script>
$(function(){
  $('#idProveedor').on('change', function(){
    $.post('<?= url('admin/inventario') ?>', {idProveedor: $(this).val()}, function(p){
      if(p){
        $('#nombreProveedor').val(p.nombreProveedor);
        $('#apellidoProveedor').val(p.apellidoProveedor);
        $('#telefonoProveedor').val(p.telefonoProveedor);
        $('#direccionProveedor').val(p.direccionProveedor);
        $('#correoProveedor').val(p.correoProveedor);
      }
    }, 'json');
  });
  $('#buscar-productos').click(function(){
    $.post('<?= url('admin/buscarProducto') ?>', {searchTerm: $('#ip-buscar-productos').val()}, function(html){
      $('#tabla table').html(html);
    });
  });
  $.getJSON('<?= url('admin/bajoStock') ?>', function(list){
    if(list && list.length){
      var m = 'Productos con stock < 10:\n';
      list.forEach(function(p){ m += ' - '+p.codigoProducto+' '+p.nombreProductos+'\n'; });
      alert(m);
    }
  });
});
</script>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
