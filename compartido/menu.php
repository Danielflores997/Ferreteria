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
            <a href="nosotros.php" class="Catalogo">Nosotros</a>
            <a href="index.php" class="Catalogo">Catálogo</a>
            <a href="pinturas.php" class="Pintura">Pintura</a>
            <a href="electricas.php" class="Electricas">Eléctricas</a>
            <a href="herramientas.php" class="Herramientas_Manuales">Herramientas</a>
            <a href="accesorios.php" class="Accesorios">Accesorios</a>
            <a href="carpinteria.php" class="Accesorios">Carpintería</a>
            <a href="plomeria.php" class="Accesorios">Plomería</a>
            <a href="jardineria.php" class="Accesorios">Jardinería</a>
            <?php
            session_start();
            if (isset($_SESSION['correo'])) {
                // Mostrar el botón adicional para visitar el perfil solo si el usuario está logueado
                echo '<button class="btn-login Perfil"><a href="perfilCliente.php" class="btn-login">Mi Perfil</a></button>';
            } else {
                // Si el usuario no está logueado, mostrar los botones para acceder y registrarse
                echo '
                <button class="btn-login">
                    <a class="btn-login" href="loginCliente.php">Acceder</a>
                </button>
                <button class="btn-login">
                    <a class="btn-login" href="registroCliente.php">Regístrate</a>
                </button>';
            }
            ?>
        </div>
    </nav>
</div>
