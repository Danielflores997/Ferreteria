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
<section style="padding:2rem">
    <h2>Carrito de compras</h2>
    <div id="lista-carrito"></div>
    <button id="btn-comprar" class="btn-ingresar">Procesar compra</button>
</section>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
<script>
function render() {
    var items = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    var el = document.getElementById('lista-carrito');
    if (!items.length) { el.innerHTML = '<p>Carrito vacío</p>'; return; }
    el.innerHTML = '<table border="1" width="100%"><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th></tr>' +
        items.map(i => `<tr><td>${i.titulo}</td><td>${i.precio}</td><td>${i.cantidad}</td><td>${i.precio*i.cantidad}</td></tr>`).join('') + '</table>';
}
render();
document.getElementById('btn-comprar').onclick = function() {
    var items = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    fetch('<?= url('cliente/procesarCompra') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({items})
    }).then(r => r.json()).then(d => {
        alert(d.message || 'OK');
        if (d.success) { localStorage.removeItem('carritoProductos'); render(); }
    });
};
</script>
</body></html>
