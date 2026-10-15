<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../../../compartido/menu.php'; ?>

<link rel="stylesheet" type="text/css" href="../CSS/index.css">

<h2 class="catalogo">Productos por categoría</h2>
<section class="contenedor">
    <div class="contenedor-items">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $row): ?>
                <div class="item">
                    <span class="titulo-item"><?php echo htmlspecialchars($row['nombreProductos']); ?></span>
                    <img class="img-catalogo" src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombreProductos']); ?>">
                    <span class="titulo-item"><?php echo htmlspecialchars($row['descripcionProducto']); ?></span>
                    <span class="precio-item">$ <?php echo number_format((float)$row['valorProducto'], 0, ',', '.'); ?></span>
                    <button class="boton-item"
                            data-titulo="<?php echo htmlspecialchars($row['nombreProductos']); ?>"
                            data-imagen="<?php echo htmlspecialchars($row['imagen']); ?>"
                            data-precio="<?php echo htmlspecialchars($row['valorProducto']); ?>"
                            data-idproducto="<?php echo htmlspecialchars($row['idProducto']); ?>"
                            onclick="agregarAlCarrito(this)">Agregar al Carrito</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos en esta categoría.</p>
        <?php endif; ?>
    </div>

    <div class="icono-carrito">
        <a href="../public/carrito.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</section>

<script>
function agregarAlCarrito(button) {
    var titulo = button.getAttribute('data-titulo');
    var imagen = button.getAttribute('data-imagen');
    var precio = button.getAttribute('data-precio');
    var idProducto = button.getAttribute('data-idproducto');

    button.textContent = 'Agregado al carrito';
    button.classList.remove('boton-item');
    button.classList.add('boton-agregado');

    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    var productoExistente = carritoProductos.find(producto => producto.idProducto === idProducto);

    if (productoExistente) {
        productoExistente.cantidad++;
    } else {
        carritoProductos.push({
            idProducto: idProducto,
            titulo: titulo,
            imagen: imagen,
            precio: precio,
            cantidad: 1
        });
    }

    localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
