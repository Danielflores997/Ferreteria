<link rel="stylesheet" type="text/css" href="../CSS/menu.css">
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
            <a href="../public/nosotros.php" class="Catalogo">Nosotros</a>
            <a href="../public/index.php" class="Catalogo">Catálogo</a>
            <a href="../public/ventas.php?categoria=2" class="Pintura">Pintura</a>
            <a href="../public/ventas.php?categoria=4" class="Electricas">Eléctricas</a>
            <a href="../public/ventas.php?categoria=1" class="Herramientas_Manuales">Herramientas</a>
            <a href="../public/ventas.php?categoria=9" class="Accesorios">Accesorios</a>
            <a href="../public/ventas.php?categoria=5" class="Accesorios">Carpintería</a>
            <a href="../public/ventas.php?categoria=7" class="Accesorios">Plomería</a>
            <a href="../public/ventas.php?categoria=8" class="Accesorios">Jardinería</a>
            <?php
            session_start();
            if (isset($_SESSION['correo'])) {
                echo '<button class="btn-login Perfil"><a href="../public/perfilCliente.php" class="btn-login">Mi Perfil</a></button>';
            } else {
                echo '
                <button class="btn-login">
                    <a class="btn-login" href="../public/login.php">Acceder</a>
                </button>
                <button class="btn-login">
                    <a class="btn-login" href="../public/registroCliente.php">Regístrate</a>
                </button>';
            }
            ?>
        </div>
    </nav>
</div>
