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
  <?php 
    include "../compartido/menu.php";
    include "../compartido/conexion.php";
    ?>
  
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
            <?php
            $sql = "SELECT * FROM productos";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="item">
                        <span class="titulo-item"><?php echo $row["nombreProductos"]; ?> </span>
                        <img class="img-catalogo" src="<?php echo $row["imagen"]; ?>">
                        <span class="precio-item">$ <?php echo number_format($row["valorProducto"], 0, ',', '.'); ?></span>
                        <button class="boton-item"
                                data-titulo="<?php echo $row["nombreProductos"]; ?>"
                                data-imagen="<?php echo $row["imagen"]; ?>"
                                data-precio="<?php echo $row["valorProducto"]; ?>">
                            Agregar al Carrito
                        </button>
                    </div> 
                    <?php                            
                }
            } else {
                echo "No se encontraron resultados.";
            }
            ?>
        <div class="icono-carrito">
            <a href="../Php/carrito.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </div>
</section>
</body>
  <?php
    include '../compartido/carrito.php';
    include "../compartido/footer.php"; 
  ?>
</html>