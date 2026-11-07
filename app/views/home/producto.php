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
                <input type="text" name="q" value="<?= e($search ?? '') ?>" placeholder="Buscar en el catálogo">
                <button type="submit">Buscar</button>
            </form>
        </div>
    </header>

    <main>
        <section class="contenedor">
            <div class="contenedor-items">
                <div class="producto-detalle">
                    <img class="producto-imagen" src="<?= e($producto['imagen']) ?>" alt="<?= e($producto['nombreProductos']) ?>">
                    <h2 class="producto-titulo"><?= e($producto['nombreProductos']) ?></h2>
                    <p class="producto-descripcion"><?= e($producto['descripcionProducto']) ?></p>
                    <p class="producto-categoria">Categoria: <?= e($producto['categoriaNombre']) ?></p>
                    <p class="producto-vendedor">Vendido por: <?= e($producto['tenantNombre'] ?? 'Sin información') ?></p>
                    <p class="producto-precio">$ <?= money($producto['valorProducto']) ?></p>
                    <button class="boton-item"
                        data-titulo="<?= e($producto['nombreProductos']) ?>"
                        data-imagen="<?= e($producto['imagen']) ?>"
                        data-precio="<?= e($producto['valorProducto']) ?>"
                        data-idproducto="<?= e($producto['idProducto']) ?>"
                        onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
                </div>

                <div class="producto-similares">
                    <h3>Productos similares</h3>
                    <?php if (empty($similares)): ?>
                        <p>No hay productos similares disponibles.</p>
                    <?php else: ?>
                        <div class="similares-grid">
                            <?php foreach ($similares as $sim): ?>
                                <div class="similar-item">
                                    <img src="<?= e($sim['imagen']) ?>" alt="<?= e($sim['nombreProductos']) ?>">
                                    <span class="similar-titulo"><?= e($sim['nombreProductos']) ?></span>
                                    <span class="similar-precio">$ <?= money($sim['valorProducto']) ?></span>
                                    <span class="similar-vendedor">por <?= e($sim['tenantNombre'] ?? '') ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>