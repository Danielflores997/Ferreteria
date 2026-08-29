<div class="icono-carrito">
    <a href="<?= url('cliente/carrito') ?>" title="Ver carrito">
        <i class="fa-solid fa-cart-shopping"></i>
    </a>
</div>
<script>
function agregarAlCarrito(button) {
    var titulo = button.getAttribute('data-titulo');
    var imagen = button.getAttribute('data-imagen');
    var precio = button.getAttribute('data-precio');
    var idProducto = button.getAttribute('data-idproducto');

    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    var existente = carritoProductos.find(function (p) { return p.idProducto === idProducto; });
    if (existente) {
        existente.cantidad++;
    } else {
        carritoProductos.push({ idProducto: idProducto, titulo: titulo, imagen: imagen, precio: precio, cantidad: 1 });
    }
    localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));

    var textoOriginal = button.dataset.textoOriginal || button.textContent;
    button.dataset.textoOriginal = textoOriginal;
    button.textContent = 'Agregado al carrito';
    button.classList.add('boton-agregado');
    setTimeout(function () {
        button.textContent = textoOriginal;
        button.classList.remove('boton-agregado');
    }, 1200);
}
</script>
