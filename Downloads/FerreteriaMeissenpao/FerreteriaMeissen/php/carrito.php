<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/carrito.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Ferreteria Meissen</title>
</head>
<body>
    <!--carrito de compras-->
    <?php
    include 'compartido/menu.php';
    ?>
        <div class="carrito">
            <div class="heder-carrito">
                <h2 class="titulo-carrito">Tu Carrito</h2>
            </div>
            <div class="carrito-items">
                <div class="carrito-item">
                    <img src="imagenes/Luz led.jpg" alt="" width="80px">
                    <div class="carrito-item-detalles">
                        <span class="carrito-item-titulo">Luz led</span>
                        <div class="selector-cantidad">
                            <i class="fa-solid fa-minus restar-cantidad"></i>
                            <input type="text" value="1" class="carrito-item-cantidad" disabled>
                            <i class="fa-solid fa-plus sumar-cantidad"></i>
                        </div>
                        <span class="carrito-item-precio">$25.000</span> 
                    </div>
                    <span class="btn-eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                </div>
            </div>

            <div class="carrito-item">
                <img src="imagenes/tubos.jpg" alt="" width="80px">
                <div class="carrito-item-detalles">
                    <span class="carrito-item-titulo">Tubos pvc</span>
                    <div class="selector-cantidad">
                        <i class="fa-solid fa-minus restar-cantidad"></i>
                        <input type="text" value="2" class="carrito-item-cantidad" disabled>
                        <i class="fa-solid fa-plus sumar-cantidad"></i>
                    </div>
                    <span class="carrito-item-precio">$30.000</span> 
                </div>
                <span class="btn-eliminar">
                    <i class="fa-solid fa-trash"></i>
                </span>
            </div>
            <div class="carrito-total">
                <div class="fila">
                    <strong>Tu Total</strong>
                    <span class="carrito-precio-total">
                        $85.000.00
                    </span>
                </div>
                <button class="btn-pagar">Pagar <i class="fa-solid fa-bag-shopping"></i></button>
            </div>
        </div>
        <?php
        include 'compartido/footer.php';
        ?>
</body>
</html>