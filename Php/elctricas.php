<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/electricas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Ferreteria Meissen</title>
</head>
<body>
    <div class="encabezado">
    <header>
        <div class = titulo>
        <h1>FERRETERIA MEISSEN</h1>
        </div>    
        <div class="logo" >
        <img src="..//imagenes/ferreteria.jpeg" alt="logo ferreteria">
        </div>
    </header>
    <nav class="navbar">
        <div class="lista">
        <a href="index.html" class="CatalogoTodo">Catalogo</a>
        <a href="#" class="Pintura">Pintura</a>
        <a href="elctricas.html" class="Electricas">Electricas</a>
        <a href="#" class="Herramientas_Manuales">Herramientas Manuales</a>
        <a href="#" class="Accesorios">Accesorios</a>
        <button class="btn-login">
        <a class="btn-login"href="loginCliente.html">Acceder</a>
        </button>
        <button class="btn-login">
        <a class="btn-login"href="registroCliente.html">Regístrate</a>
        </button>
        </div>
    </div>
    </nav>
        <h2 class="catalogo">Electricas</h2>
        <section class="contenedor">
        <!--contenedor de elementos-->
        <div class="contenedor-items">
            <div class="item">
                <span class="titulo-item">Taladro Black+Decker</span>
                <img class="img-catalogo" src="../imagenes/Taladro Black Deker.jpg" alt="img Taladro">
                <span class="precio-item">$299.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">pulidora Black+Decker</span>
                <img class="img-catalogo"src="../imagenes\Pulidora Blak Deker.webp" alt="img pulidora">
                <span class="precio-item">$229.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Taladro Bosch</span>
                <img class="img-catalogo" src="../imagenes/Taladro Bosch.jpg" alt="img Taladro">
                <span class="precio-item">$429.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">pulidora dewalt</span>
                <img class="img-catalogo" src="../imagenes/Pulidora Dewalt.webp" alt="img Pulidora">
                <span class="precio-item">$599.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Taladro Ducati</span>
                <img class="img-catalogo" src="../imagenes/Taladro de impacto Ducati.webp" alt="img Taladro">
                <span class="precio-item">$359.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Pulidora Makita</span>
                <img class="img-catalogo" src="../imagenes/Pulidora Makita.jpg" alt="img pulidora">
                <span class="precio-item">$120.000</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Taladro DeWalt Inalambrico</span>
                <img class="img-catalogo" src="../imagenes/Taladro Dwalt Inalambrico.jpg" alt="img Taladro">
                <span class="precio-item">$699.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Pulidora Truper</span>
                <img class="img-catalogo" src="../imagenes/Pulidora Marca Truper.jpg" alt="img Pulidora">
                <span class="precio-item">$329.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Taladro DeWalt </span>
                <img class="img-catalogo" src="../imagenes/Taladro Dwalt.jpg" alt="img Taladro">
                <span class="precio-item">$399.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Pulidora Stanley</span>
                <img class="img-catalogo" src="../imagenes/Pulidora Stanley.jpg" alt="img Pulidora">
                <span class="precio-item">$299.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Taladro Makita</span>
                <img class="img-catalogo" src="../imagenes/Taladro Makita.jpg" alt="img Taladro">
                <span class="precio-item">$299.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
            <div class="item">
                <span class="titulo-item">Pulidora Truper 5.000 rpm</span>
                <img class="img-catalogo" src="../imagenes/Pulidora Truper.jpg" alt="img pulidora">
                <span class="precio-item">$199.900</span>
                <button class="boton-item" onclick="agregarAlCarrito()">Agregar al Carrito</button>
            </div>
        </div>
    </section>

        <script>
            function agregarAlCarrito() {
            window.location.href = "carrito.html";
            }
            </script>
</body>
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
</html>