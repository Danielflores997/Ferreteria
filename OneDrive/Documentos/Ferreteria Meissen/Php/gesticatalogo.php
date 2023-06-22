<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="./app.js" async></script>
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Ferreteria Meissen</title>
</head>
<body>
    <?php
        include "../compartido/conexion.php";
        $sql = "SELECT * FROM productos";
        $result = mysqli_query($conn, $sql);
    ?>
    <header>
        <h1>Ferreteria Meissen</h1>
        <div class="logo"></div>
        <nav>
            <ul>
                <li><a href="#"></a></li>
            </ul>
        </nav>
    </header>
    <section class="contenedor">

        <div class="contenedor-items">
            <?php 
                while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="item">
                <span class="titulo-item"><?php echo $row['nombreProductos']?></span>
                <img src="<?php echo $row['imagen'] ?>" alt="" class="img-item">
                <span class="precio-item"><?php echo $row['valorProducto'] ?></span>
                <button class="btn-item">Modificar</button>
                <button class="btn-eliminar">Eliminar</button>
            </div>
            <?php
                }
            ?>
        </div>
    </section>       
</body>
</html>