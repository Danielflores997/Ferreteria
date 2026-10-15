<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include "../compartido/conexion.php";

// Obtener el correo del usuario de la sesión
$correo = $_SESSION['correo'];

// Realizar la consulta para obtener la información del usuario, incluyendo la foto de perfil
$stmt = $conn->prepare("SELECT fotoPerfil FROM usuario WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($fotoPerfil);
$stmt->fetch();
$stmt->close();
$conn->close();

// Si no se encontró la foto de perfil, utilizar una por defecto
if (!$fotoPerfil) {
    $fotoPerfil = '../imagenes/default_avatar.png';
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
        <h3>
                <!-- Mostrar el rol del usuario -->
                <?php
                if (isset($_SESSION['rol'])) {
                    $rol = $_SESSION['rol'];
                    if ($rol == 1) {
                        echo "Administrador";
                    } elseif ($rol == 2) {
                        echo "Vendedor";
                    } else {
                        echo "Cliente";
                    }
                }
                ?>
            </h3>
            <div id="foto">
                <img class="foto-perfil" src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
            </div>
            <div class="nom-usuario">
                <!-- Aquí puedes mostrar el correo del usuario -->
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido: <br>" . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
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
    <?php include '../compartido/footer.php'; ?>
</body>
</html>
