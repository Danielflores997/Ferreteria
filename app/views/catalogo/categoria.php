<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title) ?></title>
</head>
<body>
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<h2 class="catalogo"><?= e($categoria) ?></h2>
<section class="contenedor">
    <div class="contenedor-items">
        <?php if (empty($productos)): ?>
            <p>No hay productos en esta categoría.</p>
        <?php else: foreach ($productos as $row): ?>
            <div class="item">
                <span class="titulo-item"><?= e($row['nombreProductos']) ?></span>
                <img class="img-catalogo" src="<?= e($row['imagen']) ?>" alt="">
                <span class="titulo-item"><?= e($row['descripcionProducto']) ?></span>
                <span class="precio-item">$ <?= money($row['valorProducto']) ?></span>
            </div>
        <?php endforeach; endif; ?>
    </div>
</section>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
