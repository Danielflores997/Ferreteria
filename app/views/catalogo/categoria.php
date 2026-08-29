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
<h2 class="catalogo"><?= e($categoria) ?><?php if (isset($total)): ?> <small style="font-weight:400;font-size:.7em">(<?= (int)$total ?>)</small><?php endif; ?></h2>
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
                <img class="img-catalogo" src="<?= e($row['imagen']) ?>" alt="<?= e($row['nombreProductos']) ?>">
                <span class="titulo-item"><?= e($row['descripcionProducto']) ?></span>
                <span class="precio-item">$ <?= money($row['valorProducto']) ?></span>
                <button class="boton-item"
                    data-titulo="<?= e($row['nombreProductos']) ?>"
                    data-imagen="<?= e($row['imagen']) ?>"
                    data-precio="<?= e($row['valorProducto']) ?>"
                    data-idproducto="<?= e($row['idProducto']) ?>"
                    onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
            </div>
        <?php endforeach; endif; ?>
    </div>
    <div class="icono-carrito">
        <a href="<?= url('cliente/carrito') ?>"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</section>
<?php require APP_PATH . '/views/partials/carrito_flotante.php'; ?>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
<script>
function agregarAlCarrito(button) {
    var titulo = button.getAttribute('data-titulo');
    var imagen = button.getAttribute('data-imagen');
    var precio = button.getAttribute('data-precio');
    var idProducto = button.getAttribute('data-idproducto');
    button.textContent = 'Agregado al carrito';
    button.classList.add('boton-agregado');
    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    var existente = carritoProductos.find(p => String(p.idProducto) === String(idProducto));
    if (existente) { existente.cantidad++; }
    else { carritoProductos.push({idProducto:idProducto, titulo:titulo, imagen:imagen, precio:precio, cantidad:1}); }
    localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
}
</script>
</body></html>
