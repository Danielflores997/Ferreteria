<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="../imagenes/">
    <link rel="stylesheet" href="../CSS/registroCliente.css">
    <title>Registro</title>
</head>
<body>
    <?php include __DIR__ . '/../../../compartido/menu.php'; ?>

    <form class="login" action="../compartido/registro.php" method="POST">
        <h2>Registrate</h2>

        <?php
        include __DIR__ . '/../../../compartido/conexion.php';
        if (isset($_POST['registro'])) {
            include __DIR__ . '/../../../compartido/registro.php';
        }
        ?>

        <div class="contenedor-form">
            <select name="tipo_documento" id="tipo_documento">
                <option value="na" select>Tipo Documento</option>
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="CE">Cédula Extrangeria</option>
            </select>
            <label>
                <input type="text" id="Documento" placeholder="Documento" name="documento">
            </label>
            <label>
                <input type="text" id="Nombres" placeholder="Nombres" name="nombre">
            </label>
            <label>
                <input type="text" id="Apellidos" placeholder="Apellidos" name="apellido">
            </label>
            <label>
                <input type="email" id="CorreoElectronico" placeholder="Correo Electrónico" name="Correo">
            </label>
            <label>
                <input type="password" id="Contraseña" placeholder="Contraseña" name="Contraseña">
            </label>
            <label>
                <input type="password" id="Confirmar" placeholder="Confirmar Contraseña" name="Confirmar">
            </label>
            <label for="tratamiento-datos">
                <input type="checkbox" class="tratamiento-datos" name="tratamiento-datos">
                Acepto tratamiento de datos
            </label>
            <button class="btn-ingresar" type="submit" name="registro">Registrar</button>
        </div>
    </form>
    <?php include __DIR__ . '/../../../compartido/footer.php'; ?>
</body>
</html>
