<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/carrito.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Ferreteria Meissen</title>
</head>
<body>
    <?php include "../compartido/menu.php"; ?> 
<!--carrito de compras-->
<div class="carrito">
  <div class="heder-carrito">
    <h2 class="titulo-carrito">Tu Carrito</h2>
  </div>
  <div class="carrito-items" id="carrito-items">
    <!-- Aquí se agregarán los productos dinámicamente -->
  </div>
  <div class="carrito-total">
    <div class="fila">
      <strong>Tu Total</strong>
      <span class="carrito-precio-total">$0.00</span>
    </div>
    <button class="btn-pagar">Pagar <i class="fa-solid fa-bag-shopping"></i></button>
  </div>
</div>

<script src="../JavaScript/carrito.js"></script>

<script>
  function mostrarCarrito() {
    var carritoItems = document.getElementById('carrito-items');
    carritoItems.innerHTML = '';

    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];

    carritoProductos.forEach(function (producto) {
      var nuevoItem = document.createElement('div');
      nuevoItem.classList.add('carrito-item');

      var contenido = `
  <img src="${producto.imagen}" alt="" width="80px">
  <div class="carrito-item-detalles">
    <span class="carrito-item-titulo">${producto.titulo}</span>
    <div class="selector-cantidad">
      <button class="btn-restar"><i class="fa-solid fa-minus"></i></button>
      <input type="text" value="1" class="carrito-item-cantidad" disabled>
      <button class="btn-sumar"><i class="fa-solid fa-plus"></i></button>
    </div>
    <span class="carrito-item-precio">$${producto.precio}</span>
  </div>
  <button class="btn-eliminar"><i class="fa-solid fa-trash"></i></button>
`;

var nuevoItem = document.createElement('div');
nuevoItem.classList.add('carrito-item');
nuevoItem.innerHTML = contenido;
carritoItems.appendChild(nuevoItem);

var restarBtn = nuevoItem.querySelector('.btn-restar');
restarBtn.addEventListener('click', function() {
  restarCantidad();
});

var sumarBtn = nuevoItem.querySelector('.btn-sumar');
sumarBtn.addEventListener('click', function() {
  sumarCantidad();
});

      nuevoItem.innerHTML = contenido;
      carritoItems.appendChild(nuevoItem);
    });

    actualizarTotal();
  }

  function actualizarTotal() {
    var total = 0;
    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];

    carritoProductos.forEach(function (producto) {
      total += producto.precio;
    });

    var carritoPrecioTotal = document.querySelector('.carrito-precio-total');
    carritoPrecioTotal.innerText = '$' + total.toFixed(2);
  }

  mostrarCarrito();
</script>
    <?php include "../compartido/footer.php"; ?>
</body>
</html>