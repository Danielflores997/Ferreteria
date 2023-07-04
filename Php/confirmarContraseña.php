<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../imagenes/">
    <link rel="stylesheet" href="../CSS/confirmarContraseña.css">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <!-- Inicia encabezado -->
    <div class="encabezado">
        <header>
            <div class="titulo">
                <h1>FERRETERIA MEISSEN</h1>
            </div>    
            <div class="logo">
                <img src="../imagenes/ferreteria.jpeg" alt="logo ferreteria">
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
                    <a class="btn-login" href="loginCliente.html">Acceder</a>
                </button>
                <button class="btn-login">
                    <a class="btn-login" href="registroCliente.html">Regístrate</a>
                </button>
            </div>
        </nav>
    </div>
    <!-- Fin encabezado -->

    <form class="login">
        <h2>Recuperar Contraseña</h2>
        <div class="contenedor-form">
                <input type="email" id="Correo" placeholder="Correo Electronico">
                <div class="parrafo">    
            <p>Introduce tu dirección de correo electrónico
            o tu nombre de usuario para que podamos enviarte un enlace para restablecer tu contraseña.</p>
            </div>
            <button class="btn-ingresar">Restablecer</button>
        </div>
    </form>
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