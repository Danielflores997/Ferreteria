<?php
session_start();

if (isset($_SESSION['correo'])) {
    header('Location: vistacatalogo.php'); // Redirigir al usuario si ya ha iniciado sesión
    exit();
}
?>

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
  <?php include "../compartido/conexion.php"; ?>
  
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
            <!--contenedor de elementos-->
            <div class="contenedor-items">
                <?php
                $sql = "SELECT * FROM productos";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="item">
                            <span class="titulo-item"><?php echo $row["nombreProductos"];?> </span>
                            <img class="img-catalogo" src="<?php echo $row["imagenes"]; ?>">
                            <span class="precio-item">$ <?php echo number_format($row["valorProducto"], 0, ',', '.');?></span>
                            <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
                        </div> 
                        <?php                            
                    }
                } else {
                    echo "No se encontraron resultados.";
                }
                ?>
            </div>
        </section>

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