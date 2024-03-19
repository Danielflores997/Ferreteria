<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/carrito.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Carrito de Compras</title>
</head>

<body>
    <?php include "../compartido/menu.php"; ?>
    <h2 class="catalogo">Carrito de Compras</h2>
    <section class="contenedor">
        <div class="contenedor-items">
            <div class="item">
                <h3>Productos en el Carrito:</h3>
                <ul class="lista-carrito" id="carrito-lista">
                    <!-- Aquí se mostrarán los productos del carrito -->
                </ul>
                <h3 class="total carrito-precio-total">Total: $0</h3>
                <button class="btn-vaciar-carrito">Vaciar Carrito</button>
                <!-- Agregar un formulario oculto para procesar la compra -->
                <form id="form-comprar" method="POST" action="../compartido/procesar_compra.php" style="display: none;">
                    <input type="hidden" id="input-productos" name="productos">
                </form>
                <!-- Botón para realizar la compra -->
                <button class="btn-comprar-carrito">Comprar</button>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        function mostrarCarrito() {
            var carritoItems = document.getElementById('carrito-lista');
            carritoItems.innerHTML = '';

            var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];

            // Depurar: Imprimir el contenido del carrito en la consola
            console.log("Productos en el carrito:", carritoProductos);

            carritoProductos.forEach(function (producto) {
                var nuevoItem = document.createElement('li');
                nuevoItem.classList.add('carrito-item');
                nuevoItem.innerHTML = `
                    <img src="${producto.imagen}" alt="" width="80px">
                    <div class="carrito-item-detalles">
                        <span class="carrito-item-titulo">${producto.titulo}</span>
                        <div class="selector-cantidad">
                            <button class="restar-cantidad">-</button>
                            <span class="carrito-item-cantidad">${producto.cantidad}</span>
                            <button class="sumar-cantidad">+</button>
                        </div>
                        <span class="carrito-item-precio">$${producto.precio}</span>
                    </div>
                    <button class="btn-eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                `;

                nuevoItem.querySelector('.restar-cantidad').addEventListener('click', function () {
                    restarCantidad(producto);
                });

                nuevoItem.querySelector('.sumar-cantidad').addEventListener('click', function () {
                    sumarCantidad(producto);
                });

                nuevoItem.querySelector('.btn-eliminar').addEventListener('click', function () {
                    eliminarProducto(producto);
                });

                carritoItems.appendChild(nuevoItem);
            });

            actualizarTotal();
        }

        function actualizarTotal() {
            var total = 0;
            var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];

            carritoProductos.forEach(function (producto) {
                total += producto.precio * producto.cantidad;
            });

            var carritoPrecioTotal = document.querySelector('.carrito-precio-total');
            carritoPrecioTotal.innerText = '$' + total.toFixed(0);
        }

        function restarCantidad(producto) {
            var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
            var index = carritoProductos.findIndex(item => item.titulo === producto.titulo);

            if (index !== -1 && carritoProductos[index].cantidad > 1) {
                carritoProductos[index].cantidad--;
                localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
                mostrarCarrito();
            }
        }

        function sumarCantidad(producto) {
    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    var index = carritoProductos.findIndex(item => item.titulo === producto.titulo);

    if (index !== -1) {
        carritoProductos[index].cantidad++; // Incrementar la cantidad del producto en el carrito
        localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
        mostrarCarrito();
    }
}

        function eliminarProducto(producto) {
            var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
            var index = carritoProductos.findIndex(item => item.titulo === producto.titulo);

            if (index !== -1) {
                carritoProductos.splice(index, 1);
                localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
                mostrarCarrito();
            }
        }

        $(".btn-vaciar-carrito").on("click", function () {
            localStorage.removeItem('carritoProductos');
            mostrarCarrito();
        });

        $(".btn-comprar-carrito").on("click", function () {
            var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
            // Modificar los productos para que incluyan el idProducto
            var productosIDs = carritoProductos.map(producto => {
                return { idProducto: producto.idProducto, cantidad: producto.cantidad }; // Ajuste aquí para incluir el idProducto
            });
            // Insertar los IDs en el formulario
            $("#input-productos").val(JSON.stringify(productosIDs));
            // Enviar el formulario
            $("#form-comprar").submit();
        });

        mostrarCarrito();
    });
    </script>
</body>
<?php include '../compartido/footer.php'; ?>
</html>
