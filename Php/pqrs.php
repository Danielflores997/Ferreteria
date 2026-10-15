<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/pqrs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Pinturas</title>
</head>
<body>
    <?php
    include '../compartido/menu.php';
    include '../compartido/conexion.php';
    ?>
        <form method="post" action="../compartido/peticiones.php">
        <h2>Contactanos</h2>
            <input type="text" placeholder="Nombre" name="nombre" required>

            <input type="text" placeholder="Apellido" name="apellido" required>

            <input type="text" placeholder="Direccion" name="direccion" required>

            <input type="text" placeholder="Telefono" name="telefono" required>

            <input type="text" placeholder="Correo" name="correo" required>

            <label for="motivo">Mensaje</label>
            <textarea name="motivo" required></textarea>

            <input type="submit" value="Enviar">
        </form>
        <?php
        include '../compartido/footer.php';
        ?>
    </body>
</html>