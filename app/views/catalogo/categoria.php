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
            <div style="padding:2rem;text-align:center;width:100%">
                <p>No hay productos en esta categoría<?= !empty($slug) ? ' (' . e($slug) . ')' : '' ?>.</p>
                <p><a href="<?= url('home/index') ?>">Ver catálogo completo</a></p>
            </div>
        <?php else: foreach ($productos as $row): ?>
            <div class="item">
                <span class="titulo-item"><?= e($row['nombreProductos']) ?></span>
                <img class="img-catalogo" src="<?= e(productImageUrl($row['imagen'])) ?>" alt="<?= e($row['nombreProductos']) ?>">
                <span class="titulo-item"><?= e($row['descripcionProducto']) ?></span>
                <span class="precio-item">$ <?= money($row['valorProducto']) ?></span>
                <button class="boton-item"
                    data-titulo="<?= e($row['nombreProductos']) ?>"
                    data-imagen="<?= e(productImageUrl($row['imagen'])) ?>"
                    data-precio="<?= e($row['valorProducto']) ?>"
                    data-idproducto="<?= e($row['idProducto']) ?>"
                    onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
            </div>
        <?php endforeach; endif; ?>
    </div>
    <div class="catalogo-footer">
        <p class="catalogo-resultados" aria-live="polite">
            <?php if ($total > 0): ?>
                Mostrando <?= (int)$firstItem ?>–<?= (int)$lastItem ?> de <?= (int)$total ?> productos
            <?php else: ?>
                No hay productos para mostrar
            <?php endif; ?>
        </p>
        <?php if ($pages > 1): ?>
        <?php
            $visibleStart = max(1, $page - 2);
            $visibleEnd = min($pages, $page + 2);
            $pageUrl = static fn($number) => url('home/categoria/' . $slug, ['page' => $number]);
        ?>
        <nav class="catalogo-paginacion" aria-label="Paginación de productos por categoría">
            <?php if ($page > 1): ?>
                <a class="pagina-control" href="<?= $pageUrl($page - 1) ?>" aria-label="Página anterior">
                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i><span>Anterior</span>
                </a>
            <?php endif; ?>
            <?php if ($visibleStart > 1): ?>
                <a class="pagina-numero" href="<?= $pageUrl(1) ?>">1</a>
                <?php if ($visibleStart > 2): ?><span class="paginas-omision" aria-hidden="true">…</span><?php endif; ?>
            <?php endif; ?>
            <?php for ($number = $visibleStart; $number <= $visibleEnd; $number++): ?>
                <?php if ($number === $page): ?>
                    <span class="pagina-numero activa" aria-current="page"><?= (int)$number ?></span>
                <?php else: ?>
                    <a class="pagina-numero" href="<?= $pageUrl($number) ?>"><?= (int)$number ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($visibleEnd < $pages): ?>
                <?php if ($visibleEnd < $pages - 1): ?><span class="paginas-omision" aria-hidden="true">…</span><?php endif; ?>
                <a class="pagina-numero" href="<?= $pageUrl($pages) ?>"><?= (int)$pages ?></a>
            <?php endif; ?>
            <?php if ($page < $pages): ?>
                <a class="pagina-control" href="<?= $pageUrl($page + 1) ?>" aria-label="Página siguiente">
                    <span>Siguiente</span><i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
    </div>
</section>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
