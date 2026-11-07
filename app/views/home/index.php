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
    <header>
        <div class="search-bar">
            <form method="GET" action="<?= BASE_URL ?>/home/index">
                <input type="hidden" name="page" value="1">
                <input type="text" name="q" value="<?= e($search ?? '') ?>" placeholder="Buscar producto, código o descripción">
                <button type="submit">Buscar</button>
            </form>
            <?php if ($cat): ?>
                <a href="<?= BASE_URL ?>/home/index">Cancelar filtro</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <section class="contenedor">
            <div class="contenedor-items">
                <?php if (empty($productos)): ?>
                    <p>No se encontraron resultados.</p>
                <?php else: ?>
                    <?php foreach ($productos as $row): ?>
                        <div class="item">
                            <span class="titulo-item"><?= e($row['nombreProductos']) ?></span>
                            <img class="img-catalogo" src="<?= e($row['imagen']) ?>" alt="<?= e($row['nombreProductos']) ?>">
                            <span class="categoria-item">Categoria: <?= e($row['categoriaNombre']) ?></span>
                            <span class="vendedor-item">Vendido por: <?= e($row['tenantNombre'] ?? 'Sin información') ?></span>
                            <span class="precio-item">$ <?= money($row['valorProducto']) ?></span>
                            <button class="boton-item"
                                data-titulo="<?= e($row['nombreProductos']) ?>"
                                data-imagen="<?= e($row['imagen']) ?>"
                                data-precio="<?= e($row['valorProducto']) ?>"
                                data-idproducto="<?= e($row['idProducto']) ?>"
                                data-vendedor="<?= e($row['tenantNombre'] ?? '') ?>"
                                onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Paginación simple -->
            <?php if ($pages > 1): ?>
                <div class="paginacion">
                    <?php if ($page > 1): ?>
                        <a href="?q=<?= e($search) ?>&cat=<?= e($cat) ?>&page=1">Primera</a>
                        <a href="?q=<?= e($search) ?>&cat=<?= e($cat) ?>&page=<?= $page - 1 ?>">Anterior</a>
                    <?php endif; ?>
                    <?php for ($i = max(1, $page - 2); $i <= min($pages, $page + 2); $i++): ?>
                        <span<?= ($i == $page ? ' class="activo"' : '') ?>>
                            <?= $i ?>
                        </span>
                    <?php endfor; ?>
                    <?php if ($page < $pages): ?>
                        <a href="?q=<?= e($search) ?>&cat=<?= e($cat) ?>&page=<?= $page + 1 ?>">Siguiente</a>
                        <a href="?q=<?= e($search) ?>&cat=<?= e($cat) ?>&page=<?= $pages ?>">Última</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>