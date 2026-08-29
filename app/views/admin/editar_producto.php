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
<h2>Editar producto</h2>
<form class="form-admin estrecho" action="<?= url('admin/editarProducto/'.(int)$producto['idProducto']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$producto['idProducto'] ?>">
<div class="panel">
    <h5><i class="fas fa-box"></i> Datos del producto</h5>
    <div class="campos">
        <div class="campo">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" value="<?= e($producto['codigoProducto']) ?>">
        </div>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= e($producto['nombreProductos']) ?>">
        </div>
        <div class="campo">
            <label for="valor">Precio</label>
            <input type="number" step="0.01" id="valor" name="valor" value="<?= e($producto['valorProducto']) ?>">
        </div>
        <div class="campo">
            <label for="stock">Cantidad</label>
            <input type="number" id="stock" name="stock" value="<?= e($producto['stockProducto']) ?>">
        </div>
        <div class="campo">
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria">
            <?php foreach (($categorias ?? []) as $idCat => $nom): ?>
                <option value="<?= e($idCat) ?>" <?= ((string)$idCat === (string)$producto['nombreCategoria']) ? 'selected' : '' ?>><?= e($nom) ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="campo ancho-total">
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" value="<?= e($producto['descripcionProducto']) ?>">
        </div>
        <div class="campo ancho-total">
            <label for="imagen">Imagen (ruta o URL)</label>
            <input type="text" id="imagen" name="imagen" value="<?= e($producto['imagen']) ?>">
        </div>
    </div>
</div>
<div class="acciones">
    <a href="<?= url('admin/inventario') ?>"><i class="fas fa-arrow-left"></i> Cancelar</a>
    <button type="submit" name="guardar"><i class="fas fa-save"></i> Guardar cambios</button>
</div>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
