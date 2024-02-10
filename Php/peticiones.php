<!DOCTYPE html>
<html lang="en">
<?php
include '../compartido/conexion.php';


// Resto del código...
?>

<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); // Redirigir si el usuario no ha iniciado sesión
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Peticiones.css">
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
                <img src="../imagenes/administrador ferreteria.jpg" alt="">
            </div>
            <div class="nom-usuario">
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido:<br> " . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
        </div>
        <!-- peticiones -->
        <div class="contenedor-tabla-peticiones">
            <?php
            // Consulta SQL para obtener los datos de la tabla "peticiones"
            $sql = "SELECT * FROM peticiones";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='contenedor-tabla-peticiones'>
                <h2>Peticiones</h2>";
                echo "<table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Motivo</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Nombre'] . "</td>";
                    echo "<td>" . $row['Apellido'] . "</td>";
                    echo "<td>" . $row['Direccion'] . "</td>";
                    echo "<td>" . $row['Telefono'] . "</td>";
                    echo "<td>" . $row['Correo'] . "</td>";
                    echo "<td>" . $row['Motivo'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "</div>";
            } else {
                echo '<div class ="mensajes-alertas"> No se encontraron resultados.
                    <div class ="mensaje-boton"><a href="../Php/index.php">Aceptar</a>
                    </div>' . $mysqli->error;
            }
            ?>
        </div>
    </div>
    <?php include "../compartido/footer.php"; ?>
</body>

</html>
