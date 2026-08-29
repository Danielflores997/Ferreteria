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
<div class="slider">
    <ul>
        <li><img src="<?= asset('imagenes/ferreteria-norte-banner.jpg') ?>" alt="banner1"></li>
        <li><img src="<?= asset('imagenes/herramientas-png.png') ?>" alt="banner2"></li>
        <li><img src="<?= asset('imagenes/slide1-1ferreteria.png') ?>" alt="banner3"></li>
        <li><img src="<?= asset('imagenes/ferreteria-ferromar-.jpg') ?>" alt="banner4"></li>
    </ul>
</div>
<h2 class="catalogo">Productos</h2>
<section class="contenedor">
    <div class="contenedor-items">
        <?php if (empty($productos)): ?>
            <p>No se encontraron resultados.</p>
        <?php else: foreach ($productos as $row): ?>
            <div class="item">
                <span class="titulo-item"><?= e($row['nombreProductos']) ?></span>
                <img class="img-catalogo" src="<?= e($row['imagen']) ?>" alt="">
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
    var existente = carritoProductos.find(p => p.idProducto === idProducto);
    if (existente) { existente.cantidad++; }
    else { carritoProductos.push({idProducto, titulo, imagen, precio, cantidad: 1}); }
    localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
}
</script>
</body></html>
