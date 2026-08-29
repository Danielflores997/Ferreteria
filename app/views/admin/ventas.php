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
<h4 id="titulo-tabla">Documento Venta</h4>
<form id="formulario-venta">
<div class="datos-proveedor">
<label>Tipo Documento</label>
<select name="tipoDocumentoCliente" id="select-TipoDocumentoCliente">
<option value="CC">CC</option><option value="TI">TI</option><option value="CE">CE</option>
</select>
<input type="text" id="documentoCliente" name="documentoCliente" placeholder="Documento Cliente">
<input type="text" id="nombresCliente" name="nombresCliente" placeholder="Nombres">
<input type="text" id="apellidosCliente" name="apellidosCliente" placeholder="Apellidos">
<input type="text" id="telefonoCliente" name="telefonoCliente" placeholder="Teléfono">
<input type="text" id="direccionCliente" name="direccionCliente" placeholder="Dirección">
<select name="estadoCliente" id="select-Estado"><option>Activo</option><option>Inactivo</option></select>
</div>
<h4>Agregar Productos</h4>
<label>Código</label><input type="text" id="id" name="id" placeholder="Código">
<label>Producto</label><input type="text" id="producto" name="producto">
<label>Descripción</label><input type="text" id="descripcion" name="descripcion">
<label>Categoría</label>
<select name="categoria" id="select-Categoria">
<?php foreach (($categorias ?? []) as $c): ?>
<option value="<?= e($c['idCategoria']) ?>"><?= e($c['nombreCategoria']) ?></option>
<?php endforeach; ?>
</select>
<label>Precio UNI</label><input type="text" id="Precio" name="precio">
<label>Cantidad</label><input type="text" id="cantidad" name="cantidad">
<button type="button" id="btn-guardar" name="guardar"><i class="fas fa-save"></i> Guardar</button>
<a href="<?= url('admin/reporteVentas') ?>">Reporte CSV</a>
</form>

<h4>Ventas</h4>
<div id="buscar">
<button id="buscar-venta"><i class="fas fa-search"></i></button>
<input id="ip-buscar-venta" type="text">
</div>
<div id="tabla"><table>
<tr>
<th>ID Venta</th><th>Fecha</th><th>ID producto</th><th>Producto</th><th>Descripción</th>
<th>Cantidad</th><th>Precio Unitario</th><th>Totales</th><th>Acciones</th>
</tr>
<?php $totalVentas=0; foreach (($ventas ?? []) as $row):
$sub=(float)$row['cantidad']*(float)$row['precio_unitario']; $totalVentas+=$sub; ?>
<tr>
<td><?= e($row['idVenta']) ?></td>
<td><?= e($row['fecha_venta'] ?? '') ?></td>
<td><?= e($row['idcodigo']) ?></td>
<td><?= e($row['producto']) ?></td>
<td><?= e($row['descripcion']) ?></td>
<td><?= e($row['cantidad']) ?></td>
<td><?= e($row['precio_unitario']) ?></td>
<td><?= e($sub) ?></td>
<td class="acciones">
<a href="<?= url('admin/editarVenta/'.$row['idVenta']) ?>"><i class="fas fa-edit"></i></a>
<form action="<?= url('admin/eliminarVenta') ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar venta?');">
<input type="hidden" name="id" value="<?= (int)$row['idVenta'] ?>">
<button type="submit"><i class="fas fa-trash"></i></button>
</form>
</td></tr>
<?php endforeach; ?>
<tr><td colspan="6"></td><td>Total: <?= e($totalVentas) ?></td><td></td></tr>
</table></div>
<script>
$(function(){
  $('#documentoCliente').on('change', function(){
    $.post('<?= url('admin/ventas') ?>',{documentoCliente:$(this).val()}, function(r){
      if(r){ $('#nombresCliente').val(r.nombresCliente); $('#apellidosCliente').val(r.apellidosCliente);
        $('#telefonoCliente').val(r.telefonoCliente); $('#direccionCliente').val(r.direccionCliente);
        $('#select-Estado').val(r.estadoCliente); }
    },'json');
  });
  $('#id').on('change', function(){
    $.post('<?= url('admin/ventas') ?>',{codigoProducto:$(this).val()}, function(r){
      if(r){ $('#producto').val(r.nombreProductos); $('#descripcion').val(r.descripcionProducto); $('#Precio').val(r.valorProducto);
        $('#select-Categoria option').filter(function(){ return $(this).text()==r.nombreCategoria; }).prop('selected', true);
      }
    },'json');
  });
  $('#btn-guardar').click(function(){
    $.post('<?= url('admin/ventas') ?>', {
      guardar:1, id:$('#id').val(), producto:$('#producto').val(), precio:$('#Precio').val(),
      cantidad:$('#cantidad').val(), descripcion:$('#descripcion').val(), categoria:$('#select-Categoria').val(),
      tipoDocumentoCliente:$('#select-TipoDocumentoCliente').val(), documentoCliente:$('#documentoCliente').val(),
      nombresCliente:$('#nombresCliente').val(), apellidosCliente:$('#apellidosCliente').val(),
      telefonoCliente:$('#telefonoCliente').val(), direccionCliente:$('#direccionCliente').val(),
      estadoCliente:$('#select-Estado').val()
    }, function(res){
      try{ var r=typeof res==='string'?JSON.parse(res):res; alert(r.message); if(r.success) location.reload(); }
      catch(e){ alert('Respuesta inválida'); }
    });
  });
  $('#buscar-venta').click(function(){
    $.post('<?= url('admin/buscarVenta') ?>',{searchTerm:$('#ip-buscar-venta').val()}, function(h){ $('#tabla table').html(h); });
  });
});
</script>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
