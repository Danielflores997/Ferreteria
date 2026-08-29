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
        <?php include "../compartido/menu.php"; ?>
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
    <?php include "../compartido/footer.php"; ?>
</body>
</html>