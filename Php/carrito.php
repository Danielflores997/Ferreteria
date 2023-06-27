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
    <header>
        <div class = titulo>
        <h1>FERRETERIA MEISSEN</h1>
        </div>    
        <div class="logo" >
        <img src="../imagenes/ferreteria.jpeg" alt="logo ferreteria">
        </div>
    </header>
    <nav class="navbar">
        <div class="lista">
        <a href="index.php" class="CatalogoTodo">Catalogo</a>
        <a href="#" class="Pintura">Pintura</a>
        <a href="elctricas.php" class="Electricas">Electricas</a>
        <a href="#" class="Herramientas_Manuales">Herramientas Manuales</a>
        <a href="#" class="Accesorios">Accesorios</a>
        <button class="btn-login">
        <a class="btn-login"href="loginCliente.php">Acceder</a>
        </button>
        <button class="btn-login">
        <a class="btn-login"href="registroCliente.php">Regístrate</a>
        </button>
    </nav>
        <!--carrito de compras-->
        <div class="carrito">
            <div class="heder-carrito">
                <h2 class="titulo-carrito">Tu Carrito</h2>
            </div>
            <div class="carrito-items">
                <div class="carrito-item">
                    <img src="../imagenes/Luz led.jpg" alt="" width="80px">
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
                <img src="../imagenes/tubos.jpg" alt="" width="80px">
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
        <footer>
            <h4>Ferreteria Meissen</h4>
            <div class="enlaces">
                <ul>
                    <li><a href="index.html">Catalogo</a></li>
                    <li><a href="#">Pintura</a></li>
                    <li><a href="elctricas.html">Electricas</a></li>
                    <li><a href="#">Herramientas Manuales</a></li>
                    <li><a href="#">Accesorios</a></li>
                </ul>
            </div>
            <h4>Redes sociales</h4>
            <div class="sociales">
            <div class="sociales-link">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
            </div>
        </footer>
</body>
</html>