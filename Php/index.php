<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>Ferreteria Meissen</title>
</head>
<body>
  <?php include "../compartido/menu.php"; ?>
        <div class="slider">
            <ul>
                <li>
                    <img src="../imagenes/ferreteria-norte-banner.jpg" alt="Herramientas1">
                </li>
                <li>
                    <img src="../imagenes/herramientas-png.png" alt="Herramientas2">
                </li>
                <li>
                    <img src="../imagenes/slide1-1ferreteria.png" alt="Herramientas3">
                </li>
                <li>
                    <img src="../imagenes/ferreteria-ferromar-.jpg" alt="Herramientas4">
                </li>
            </ul>
        </div>
    </nav>
    <h2 class="catalogo">Productos</h2>
<section class="contenedor">
  <div class="contenedor-items">
    <div class="item">
      <span class="titulo-item">Clavos 2.5"</span>
      <img class="img-catalogo" src="../imagenes/clavos.jpg" alt="img Clavos">
      <span class="precio-item">$3.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Clavos 2.5&quot;', '../imagenes/clavos.jpg', 3000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Bombillo 100w</span>
      <img class="img-catalogo" src="../imagenes/Bombillo.jpg" alt="img Bombillo">
      <span class="precio-item">$7.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Bombillo 100w', '../imagenes/Bombillo.jpg', 7000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Martillo</span>
      <img class="img-catalogo" src="../imagenes/martillo.jpg" alt="img Martillo">
      <span class="precio-item">$12.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Martillo', '../imagenes/martillo.jpg', 12000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Tubos PVC</span>
      <img class="img-catalogo" src="../imagenes/tubos.jpg" alt="img Tubos pvc">
      <span class="precio-item">$30.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Tubos PVC', '../imagenes/tubos.jpg', 30000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Luz led</span>
      <img class="img-catalogo" src="../imagenes/Luz led.jpg" alt="img Luz led">
      <span class="precio-item">$25.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Luz led', '../imagenes/Luz led.jpg', 25000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Escalera de Aluminio</span>
      <img class="img-catalogo" src="../imagenes/Escalera.jpg" alt="img Escalera">
      <span class="precio-item">$120.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Escalera de Aluminio', '../imagenes/Escalera.jpg', 120000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Drywall 240cm x 120cm</span>
      <img class="img-catalogo" src="../imagenes/Drywall.jpg" alt="img Drywall">
      <span class="precio-item">$70.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Drywall 240cm x 120cm', '../imagenes/Drywall.jpg', 70000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Corta Frio</span>
      <img class="img-catalogo" src="../imagenes/corta frio.jpg" alt="img corta frio">
      <span class="precio-item">$10.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Corta Frio', '../imagenes/corta frio.jpg', 10000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Cemento x 50 Kl</span>
      <img class="img-catalogo" src="../imagenes/cemento.jpg" alt="img cemento">
      <span class="precio-item">$60.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Cemento x 50 Kl', '../imagenes/cemento.jpg', 60000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Hombre solo</span>
      <img class="img-catalogo" src="../imagenes/Himbre solo.jpg" alt="img Hombre solo">
      <span class="precio-item">$12.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Hombre solo', '../imagenes/Himbre solo.jpg', 12000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Segueta con Marco</span>
      <img class="img-catalogo" src="../imagenes/cegueta.jpg" alt="img Segueta">
      <span class="precio-item">$35.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Segueta con Marco', '../imagenes/cegueta.jpg', 35000)">Agregar al Carrito</button>
    </div>
    <div class="item">
      <span class="titulo-item">Bombillo Ahorrador</span>
      <img class="img-catalogo" src="../imagenes/Bombillo ahorrador.jpg" alt="img Bombillo">
      <span class="precio-item">$10.000</span>
      <button class="boton-item" onclick="agregarAlCarrito('Bombillo Ahorrador', '../imagenes/Bombillo ahorrador.jpg', 10000)">Agregar al Carrito</button>
    </div>
  </div>
</section>

<script src="../JavaScript/carrito.js"></script>

<script>
  function agregarAlCarrito(titulo, imagen, precio) {
    var producto = {
      titulo: titulo,
      imagen: imagen,
      precio: precio
    };

    var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
    carritoProductos.push(producto);
    localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));

    mostrarCarrito();
  }

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
            <i class="fa-solid fa-minus restar-cantidad"></i>
            <input type="text" value="1" class="carrito-item-cantidad" disabled>
            <i class="fa-solid fa-plus sumar-cantidad"></i>
          </div>
          <span class="carrito-item-precio">$${producto.precio}</span>
        </div>
        <span class="btn-eliminar">
          <i class="fa-solid fa-trash"></i>
        </span>
      `;

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

</body>
  <?php include "../compartido/footer.php"; ?>
</html>