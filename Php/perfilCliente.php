<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); // Redirigir si el usuario no ha iniciado sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../CSS/comprasCliente.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
</head>
<body>
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
            <a href="nosotros.php" class="Catalogo">Nosotros</a>
            <a href="index.php" class="Catalogo">Catalogo</a>
            <a href="pinturas.php" class="Pintura">Pintura</a>
            <a href="electricas.php" class="Electricas">Electricas</a>
            <a href="herramientas.php" class="Herramientas_Manuales">Herramientas</a>
            <a href="accesorios.php" class="Accesorios">Accesorios</a>
            <a href="carpinteria.php" class="Accesorios">Carpinteria</a>
            <a href="plomeria.php" class="Accesorios">Plomeria</a>
            <a href="jardineria.php" class="Accesorios">Jardineria</a>
            <button class="btn-login">
                <a class="btn-login" href="../compartido/cerrarSesion.php">Cerrar Sesión</a>
            </button>
        </div>
    </nav>

    
    <div class="contenedor-elementos">
        <div class="menu-cliente">
        <select id="select-menu-cliente" onchange="location.href=this.value;">
                <option selected>Opciones</option>
                <option value="../Php/perfilCliente.php">Mi Perfil</option>
                <option value="comprasCliente.php">Mis Compras</option>
        </select>
        </div>
        <div class="seccion-compras">
            <br>
            <div class="tabla">
            <?php include "../compartido/perfil.php"; ?>
            </div>
        </div>
    </div>

    <?php include "../compartido/footer.php"; ?>

</body>
</html>
