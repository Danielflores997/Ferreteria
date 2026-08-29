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
<h4 id="titulo-tabla">Editar Producto</h4>
<form class="forEditar" action="<?= url('admin/editarProducto/'.(int)$producto['idProducto']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$producto['idProducto'] ?>">
<label>Código</label><input type="text" name="codigo" value="<?= e($producto['codigoProducto']) ?>">
<label>Nombre</label><input type="text" name="nombre" value="<?= e($producto['nombreProductos']) ?>">
<label>Precio</label><input type="number" name="valor" value="<?= e($producto['valorProducto']) ?>">
<label>Cantidad</label><input type="number" name="stock" value="<?= e($producto['stockProducto']) ?>">
<label>Descripción</label><input type="text" name="descripcion" value="<?= e($producto['descripcionProducto']) ?>">
<label>Categoría</label>
<select name="categoria">
<?php foreach (($categorias ?? []) as $idCat => $nom): ?>
<option value="<?= e($idCat) ?>" <?= ((string)$nom === (string)$producto['nombreCategoria'] || (string)$idCat === (string)$producto['nombreCategoria']) ? 'selected' : '' ?>><?= e($nom) ?></option>
<?php endforeach; ?>
</select>
<label>Imagen</label><input type="text" name="imagen" value="<?= e($producto['imagen']) ?>">
<button type="submit" name="guardar">Guardar Cambios</button>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
