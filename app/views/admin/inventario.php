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
<?php if (!empty($mensaje)): ?><p class="mensajes-alertas"><?= e($mensaje) ?></p><?php endif; ?>
<h2>Datos Proveedor / Agregar Productos</h2>
<form id="formulario-venta" class="form-admin" action="<?= url('admin/inventario') ?>" method="POST">
<div class="bloque">
    <h5><i class="fas fa-truck"></i> Datos del proveedor</h5>
    <div class="campos">
        <div class="campo">
            <label for="idProveedor">Documento proveedor</label>
            <input type="text" id="idProveedor" name="idProveedor" required>
        </div>
        <div class="campo">
            <label for="nombreProveedor">Nombre</label>
            <input type="text" id="nombreProveedor" name="nombreProveedor" required>
        </div>
        <div class="campo">
            <label for="apellidoProveedor">Apellido</label>
            <input type="text" id="apellidoProveedor" name="apellidoProveedor" required>
        </div>
        <div class="campo">
            <label for="telefonoProveedor">Teléfono</label>
            <input type="text" id="telefonoProveedor" name="telefonoProveedor" required>
        </div>
        <div class="campo">
            <label for="direccionProveedor">Dirección</label>
            <input type="text" id="direccionProveedor" name="direccionProveedor" required>
        </div>
        <div class="campo">
            <label for="correoProveedor">Correo</label>
            <input type="text" id="correoProveedor" name="correoProveedor" required>
        </div>
    </div>
</div>

<div class="bloque">
    <h5><i class="fas fa-box"></i> Datos del producto</h5>
    <div class="campos">
        <div class="campo">
            <label for="ultimoCodigo">Último código registrado</label>
            <input type="text" id="ultimoCodigo" value="<?= e($ultimoCodigo ?? '') ?>" readonly>
        </div>
        <div class="campo">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" required>
        </div>
        <div class="campo">
            <label for="producto">Producto</label>
            <input type="text" id="producto" name="producto" required>
        </div>
        <div class="campo">
            <label for="precio">Precio unitario</label>
            <input type="text" id="precio" name="precio" required>
        </div>
        <div class="campo">
            <label for="cantidad">Cantidad</label>
            <input type="text" id="cantidad" name="cantidad" required>
        </div>
        <div class="campo">
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria" required>
                <?php foreach (($categorias ?? []) as $c): ?>
                    <option value="<?= e($c['idCategoria']) ?>"><?= e($c['nombreCategoria']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo ancho-total">
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" required>
        </div>
        <div class="campo ancho-total">
            <label for="imagen">Imagen (ruta o URL)</label>
            <input type="text" id="imagen" name="imagen" placeholder="https://...">
        </div>
    </div>
</div>

<div class="acciones">
    <a id="btn-generar" href="<?= url('admin/reporteInventario') ?>"><i class="fas fa-file-alt"></i> Reporte CSV</a>
    <button id="btn-venta" type="submit" name="guardar"><i class="fas fa-save"></i> Guardar</button>
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
<td><?= e($row['categoriaNombre'] ?? '') ?></td>
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
