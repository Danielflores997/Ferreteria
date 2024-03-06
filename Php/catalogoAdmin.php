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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/VistaCatalogo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Visualizar Catálogo</title>
</head>
<body>
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
                <button class="btn-login">
                    <a class="btn-login" href="../compartido/cerrarSesion.php">Cerrar Sesión</a>
                </button>
            </div>
        </nav>
    </div>

    <div id="contenedor" style="display: flex;">
        <div id="menu-lateral">
            <h3>
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
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
            </div>
            <div class="nom-usuario">
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido: " . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
        </div>

        <!-- Contenido de "Productos" -->
        <div class="catalogo-container">
            <h2 class="catalogo">Productos</h2>
            <section class="contenedor">
                <div class="contenedor-items">
                    <?php
                    include "../compartido/conexion.php";
                    
                    $sql = "SELECT * FROM productos";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="item">
                                <span class="titulo-item"><?php echo $row["nombreProductos"]; ?> </span>
                                <img class="img-catalogo" src="<?php echo $row["imagen"]; ?>">
                                <span class="titulo-item"><?php echo $row["descripcionProducto"]; ?> </span>
                                <span class="precio-item">$ <?php echo number_format($row["valorProducto"], 0, ',', '.'); ?></span>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No se encontraron resultados.";
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>

    <?php include "../compartido/footer.php"; ?>
</body>
</html>


