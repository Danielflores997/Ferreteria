<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title) ?></title>
</head>
<body>
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<div class="cliente-wrap">
    <h2>Carrito de compras</h2>
    <div id="lista-carrito"></div>
    <div class="carrito-resumen" id="carrito-resumen" hidden>
        <div class="total">
            <span>Total</span>
            <strong id="carrito-total">$ 0</strong>
        </div>
        <div class="cliente-acciones">
            <a class="btn-cliente secundario" href="<?= url('home/index') ?>"><i class="fas fa-arrow-left"></i> Seguir comprando</a>
            <button type="button" class="btn-cliente secundario" id="btn-vaciar"><i class="fas fa-trash"></i> Vaciar carrito</button>
            <button type="button" class="btn-cliente" id="btn-comprar"><i class="fas fa-credit-card"></i> Procesar compra</button>
        </div>
    </div>
</div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
<script>
function leerCarrito() {
    return JSON.parse(localStorage.getItem('carritoProductos')) || [];
}

function guardarCarrito(items) {
    localStorage.setItem('carritoProductos', JSON.stringify(items));
}

function formatoMoneda(n) {
    return '$ ' + Number(n).toLocaleString('es-CO', { maximumFractionDigits: 0 });
}

function cambiarCantidad(id, delta) {
    var items = leerCarrito();
    var i = items.findIndex(function (p) { return p.idProducto === id; });
    if (i === -1) return;
    items[i].cantidad = Number(items[i].cantidad) + delta;
    if (items[i].cantidad < 1) items.splice(i, 1);
    guardarCarrito(items);
    render();
}

function eliminarProducto(id) {
    guardarCarrito(leerCarrito().filter(function (p) { return p.idProducto !== id; }));
    render();
}

function render() {
    var items = leerCarrito();
    var contenedor = document.getElementById('lista-carrito');
    var resumen = document.getElementById('carrito-resumen');

    if (!items.length) {
        contenedor.innerHTML = '<div class="cliente-panel carrito-vacio">' +
            '<i class="fa-solid fa-cart-shopping"></i>' +
            '<p>Tu carrito está vacío.</p>' +
            '<a class="btn-cliente" href="<?= url('home/index') ?>">Ver catálogo</a>' +
            '</div>';
        resumen.hidden = true;
        return;
    }

    contenedor.innerHTML = '';
    var total = 0;

    items.forEach(function (item) {
        var subtotal = Number(item.precio) * Number(item.cantidad);
        total += subtotal;

        var fila = document.createElement('div');
        fila.className = 'carrito-item';
        fila.innerHTML =
            '<img src="' + item.imagen + '" alt="">' +
            '<div class="carrito-info">' +
                '<strong>' + item.titulo + '</strong>' +
                '<span class="precio-unitario">' + formatoMoneda(item.precio) + ' c/u</span>' +
            '</div>' +
            '<div class="carrito-cantidad">' +
                '<button type="button" class="menos">-</button>' +
                '<span>' + item.cantidad + '</span>' +
                '<button type="button" class="mas">+</button>' +
            '</div>' +
            '<span class="carrito-subtotal">' + formatoMoneda(subtotal) + '</span>' +
            '<button type="button" class="carrito-eliminar" title="Eliminar"><i class="fas fa-trash"></i></button>';

        fila.querySelector('.menos').onclick = function () { cambiarCantidad(item.idProducto, -1); };
        fila.querySelector('.mas').onclick = function () { cambiarCantidad(item.idProducto, 1); };
        fila.querySelector('.carrito-eliminar').onclick = function () { eliminarProducto(item.idProducto); };

        contenedor.appendChild(fila);
    });

    document.getElementById('carrito-total').textContent = formatoMoneda(total);
    resumen.hidden = false;
}

document.getElementById('btn-vaciar').onclick = function () {
    localStorage.removeItem('carritoProductos');
    render();
};

document.getElementById('btn-comprar').onclick = function () {
    var items = leerCarrito();
    if (!items.length) return;
    fetch('<?= url('cliente/procesarCompra') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ items: items })
    }).then(function (r) { return r.json(); }).then(function (d) {
        alert(d.message || 'OK');
        if (d.success) { localStorage.removeItem('carritoProductos'); render(); }
    });
};

render();
</script>
</body></html>
