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
<h2 id="titulo-tabla">Documento Venta</h2>
<form id="formulario-venta">
<div class="panel">
<h3><i class="fas fa-user"></i> Datos del cliente</h3>
<div class="form-grid">
<div class="campo"><label for="select-TipoDocumentoCliente">Tipo documento</label>
<select name="tipoDocumentoCliente" id="select-TipoDocumentoCliente">
<option value="CC">CC</option><option value="TI">TI</option><option value="CE">CE</option>
</select></div>
<div class="campo"><label for="documentoCliente">Documento</label><input type="text" id="documentoCliente" name="documentoCliente" placeholder="Número de documento"></div>
<div class="campo"><label for="nombresCliente">Nombres</label><input type="text" id="nombresCliente" name="nombresCliente"></div>
<div class="campo"><label for="apellidosCliente">Apellidos</label><input type="text" id="apellidosCliente" name="apellidosCliente"></div>
<div class="campo"><label for="telefonoCliente">Teléfono</label><input type="text" id="telefonoCliente" name="telefonoCliente"></div>
<div class="campo"><label for="direccionCliente">Dirección</label><input type="text" id="direccionCliente" name="direccionCliente"></div>
<div class="campo"><label for="select-Estado">Estado</label>
<select name="estadoCliente" id="select-Estado"><option>Activo</option><option>Inactivo</option></select></div>
</div>
</div>

<div class="panel">
<h3><i class="fas fa-cart-plus"></i> Agregar productos</h3>
<div class="form-grid">
<div class="campo"><label for="id">Código</label><input type="text" id="id" name="id" placeholder="Código del producto"></div>
<div class="campo"><label for="producto">Producto</label><input type="text" id="producto" name="producto"></div>
<div class="campo"><label for="descripcion">Descripción</label><input type="text" id="descripcion" name="descripcion"></div>
<div class="campo"><label for="select-Categoria">Categoría</label>
<select name="categoria" id="select-Categoria">
<?php foreach (($categorias ?? []) as $c): ?>
<option value="<?= e($c['idCategoria']) ?>"><?= e($c['nombreCategoria']) ?></option>
<?php endforeach; ?>
</select></div>
<div class="campo"><label for="Precio">Precio unitario</label><input type="text" id="Precio" name="precio"></div>
<div class="campo"><label for="cantidad">Cantidad</label><input type="text" id="cantidad" name="cantidad"></div>
</div>
<div class="acciones-form">
<button type="button" class="btn" id="btn-guardar" name="guardar"><i class="fas fa-save"></i> Guardar venta</button>
<a class="btn secundario" href="<?= url('admin/reporteVentas') ?>"><i class="fas fa-file-csv"></i> Reporte CSV</a>
</div>
</div>
</form>

<div class="panel">
<h3><i class="fas fa-receipt"></i> Ventas registradas</h3>
<div id="buscar">
<input id="ip-buscar-venta" type="text" placeholder="Buscar venta...">
<button id="buscar-venta" type="button"><i class="fas fa-search"></i></button>
</div>
<div id="tabla"><table>
<thead>
<tr>
<th>ID Venta</th><th>Fecha</th><th>ID producto</th><th>Producto</th><th>Descripción</th>
<th>Cantidad</th><th>Precio Unitario</th><th>Totales</th><th>Acciones</th>
</tr>
</thead>
<tbody>
<?php $totalVentas=0; foreach (($ventas ?? []) as $row):
$sub=(float)$row['cantidad']*(float)$row['precio_unitario']; $totalVentas+=$sub; ?>
<tr>
<td><?= e($row['idVenta']) ?></td>
<td><?= e($row['fecha_venta'] ?? '') ?></td>
<td><?= e($row['idcodigo']) ?></td>
<td><?= e($row['producto']) ?></td>
<td><?= e($row['descripcion']) ?></td>
<td><?= e($row['cantidad']) ?></td>
<td>$ <?= money($row['precio_unitario']) ?></td>
<td>$ <?= money($sub) ?></td>
<td class="acciones">
<a href="<?= url('admin/editarVenta/'.$row['idVenta']) ?>" title="Editar"><i class="fas fa-edit"></i></a>
<form action="<?= url('admin/eliminarVenta') ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar venta?');">
<input type="hidden" name="id" value="<?= (int)$row['idVenta'] ?>">
<button type="submit" title="Eliminar"><i class="fas fa-trash"></i></button>
</form>
</td></tr>
<?php endforeach; ?>
<?php if (empty($ventas)): ?>
<tr><td colspan="9" class="tabla-vacia">Sin ventas registradas.</td></tr>
<?php endif; ?>
</tbody>
<tfoot>
<tr class="fila-total"><td colspan="7">Total</td><td colspan="2">$ <?= money($totalVentas) ?></td></tr>
</tfoot>
</table></div>
</div>
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
        $('#select-Categoria option').filter(function(){ return $(this).text()==r.categoriaNombre; }).prop('selected', true);
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
  $('#ip-buscar-venta').on('keypress', function(e){ if(e.which===13){ e.preventDefault(); $('#buscar-venta').click(); } });
});
</script>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
