<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Pinturas</title>
</head>
<body>
    <?php
    include '../compartido/menu.php';
    include '../compartido/conexion.php';
    ?>
    <div class="encabezado">   
        <h2 class="catalogo">Carpinteria</h2>
        <section class="contenedor">
            <!--contenedor de elementos-->
            <div class="contenedor-items">
                <?php
                $sql = "SELECT * FROM productos WHERE nombreCategoria = 5";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                    <div class="item">
                        <span class="titulo-item"><?php echo $row["nombreProductos"]; ?> </span>
                        <img class="img-catalogo" src="<?php echo $row["imagen"]; ?>">
                        <span class="titulo-item"><?php echo $row["descripcionProducto"]; ?> </span>
                        <span class="precio-item">$ <?php echo number_format($row["valorProducto"], 0, ',', '.'); ?></span>
                        <button class="boton-item"
                                data-titulo="<?php echo $row["nombreProductos"]; ?>"
                                data-imagen="<?php echo $row["imagen"]; ?>"
                                data-precio="<?php echo $row["valorProducto"]; ?>"
                                onclick="agregarAlCarrito(this)">
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
        <?php
        include '../compartido/carrito.php';
        include '../compartido/footer.php';
        ?>
    <script>
        function agregarAlCarrito(button) {
        var titulo = button.getAttribute('data-titulo');
        button.textContent =' agregado al carrito';
        button.classList.remove('boton-item');
        button.classList.add('boton-agregado');
        }
    </script>
    </div>
</body>
</html>