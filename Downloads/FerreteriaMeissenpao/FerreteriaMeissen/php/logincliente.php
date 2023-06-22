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
    <link rel="stylesheet" href="../CSS/loginCliente.css">
    <title>login Cliente</title>
</head>
<body>
    <!-- Inicia encabezado -->
   |<?php
    include 'compartido/menu.php';
    ?>
    <!-- Fin encabezado -->

    <form class="login">
        <h2>Iniciar Sesión</h2>
        <div class="contenedor-form">
            <label for=""><i class="fa-solid fa-user"></i>
                <input type="email" id="CorreoElectronico" placeholder="Correo Electrónico">
            </label>
            <label for=""><i class="fa-solid fa-key"></i>
                <input type="password" id="Contraseña" placeholder="Contraseña">    
            </label>
            <label for=""><a href="confirmarContraseña.html" class="olvidaste">¿Olvidaste tu Contraseña?</a></label>
            <button class="btn-ingresar">Ingresar</button>
        </div>
    </form>
    <footer>
        <h4>Ferreteria Meissen</h4>
        <div class="enlaces">
            <ul>
                <li><a href="index.htmlphp">Catalogo</a></li>
                <li><a href="#">Pintura</a></li>
                <li><a href="elctricas.php">Electricas</a></li>
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