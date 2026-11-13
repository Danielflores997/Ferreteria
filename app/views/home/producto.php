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
    <header class="producto-cabecera">
        <div class="search-bar">
            <form method="GET" action="<?= url('home/index') ?>">
                <input type="hidden" name="page" value="1">
                <label class="sr-only" for="producto-busqueda">Buscar producto</label>
                <input id="producto-busqueda" type="search" name="q" value="<?= e($search ?? '') ?>" placeholder="Buscar en el catálogo">
                <button type="submit"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><span>Buscar</span></button>
            </form>
        </div>
    </header>

    <main class="producto-pagina">
        <section class="producto-contenedor">
            <div class="producto-detalle">
                <div class="producto-galeria">
                    <img class="producto-imagen" src="<?= e(productImageUrl($producto['imagen'])) ?>" alt="<?= e($producto['nombreProductos']) ?>">
                </div>
                <div class="producto-informacion">
                    <p class="producto-categoria"><?= e($producto['categoriaNombre']) ?></p>
                    <h2 class="producto-titulo"><?= e($producto['nombreProductos']) ?></h2>
                    <p class="producto-descripcion"><?= e($producto['descripcionProducto']) ?></p>
                    <p class="producto-vendedor"><i class="fa-solid fa-store" aria-hidden="true"></i> Vendido por: <?= e($producto['tenantNombre'] ?? 'Sin información') ?></p>
                    <p class="producto-precio">$ <?= money($producto['valorProducto']) ?></p>
                    <button class="boton-item"
                        data-titulo="<?= e($producto['nombreProductos']) ?>"
                        data-imagen="<?= e(productImageUrl($producto['imagen'])) ?>"
                        data-precio="<?= e($producto['valorProducto']) ?>"
                        data-idproducto="<?= e($producto['idProducto']) ?>"
                        onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
                </div>
            </div>

            <section class="producto-similares">
                    <h3>Productos similares</h3>
                    <?php if (empty($similares)): ?>
                        <p>No hay productos similares disponibles.</p>
                    <?php else: ?>
                        <div class="similares-grid">
                            <?php foreach ($similares as $sim): ?>
                                <div class="similar-item">
                                    <img src="<?= e(productImageUrl($sim['imagen'])) ?>" alt="<?= e($sim['nombreProductos']) ?>">
                                    <span class="similar-titulo"><?= e($sim['nombreProductos']) ?></span>
                                    <p class="similar-descripcion"><?= e($sim['descripcionProducto'] ?? '') ?></p>
                                    <span class="similar-precio">$ <?= money($sim['valorProducto']) ?></span>
                                    <span class="similar-vendedor">por <?= e($sim['tenantNombre'] ?? '') ?></span>
                                    <button class="boton-item"
                                        type="button"
                                        data-titulo="<?= e($sim['nombreProductos']) ?>"
                                        data-imagen="<?= e(productImageUrl($sim['imagen'])) ?>"
                                        data-precio="<?= e($sim['valorProducto']) ?>"
                                        data-idproducto="<?= e($sim['idProducto']) ?>"
                                        onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
            </section>
        </section>
    </main>

    <?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>