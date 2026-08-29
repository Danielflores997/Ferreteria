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
    <?php include "../compartido/menu.php"; ?>
        <?php include "../compartido/conexion.php"; ?>
    <!-- Fin encabezado -->

    <form class="login" action="../compartido/validar.php" method="POST">
    <h2>Iniciar Sesión</h2>
    <div class="contenedor-form">
        <label for="CorreoElectronico"><i class="fa-solid fa-user"></i>
            <input type="email" id="CorreoElectronico" placeholder="Correo Electrónico" name="Correo">
        </label>
        <label for=""><i class="fa-solid fa-key"></i>
            <input type="password" id="Contraseña" placeholder="Contraseña" name="Contraseña">    
        </label>
        <label for=""><a href="confirmarContraseña.php" class="olvidaste">¿Olvidaste tu Contraseña?</a></label>
        <button class="btn-ingresar" type="submit">Ingresar</button>
    </div>
</form>
    <?php include "../compartido/footer.php"; ?>
</body>
</html>