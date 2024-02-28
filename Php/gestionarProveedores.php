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
    $fotoPerfil = '../imagenes/default_avatar.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/gestionarFuncionarios.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Funcionarios</title>
    <div class="encabezado">
        <header>
            <div class = titulo>
            <h1>FERRETERIA MEISSEN</h1>
            </div>    
            <div class="logo" >
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
        <div id="contenido">
        <div id="menu-lateral">
            <h3>Administrador</h3>
            <div id="foto">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
            </div>
            <div class="nom-usuario">
                <!-- Aquí puedes mostrar el correo del usuario -->
                <?php
                    if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido: " . $_SESSION['correo'] . "</h3>";
                    }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
        </div>

        <div class="inventario">
        <h4 id="usuarios-titulo-tabla">Proveedores</h4>
<div id="buscar">
    <button id="buscar-Proveedor"><i class="fa-solid fa-magnifying-glass"></i></button>
    <input id="ip-buscar-Proveedor" type="text">
</div>
<div id="Proveedor-tabla">
    <table>
        <tr>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre Proveedor</th>
            <th id="celda-principal">Apellido Proveedor</th>
            <th id="celda-principal">Telefono</th>
            <th id="celda-principal">Direccion</th>
            <th id="celda-principal">correo</th>
            <th id="celda-principal">Acciones</th>
        </tr>
        <?php
        include "../compartido/conexion.php";

        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM proveedor";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error al obtener los proveedores: " . mysqli_error($conn);
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['idProveedor']; ?></td>
                <td><?php echo $row['nombreProveedor']; ?></td>
                <td><?php echo $row['apellidoProveedor']; ?></td>
                <td><?php echo $row['telefonoProveedor']; ?></td>
                <td><?php echo $row['direccionProveedor']; ?></td>
                <td><?php echo $row['correoProveedor']; ?></td>
                <td class="acciones">
                <form action="../compartido/editarProveedor.php" method="POST">
                    <input type="hidden" name="tabla" value="Proveedor">
                    <input type="hidden" name="id" value="<?php echo $row['idProveedor']; ?>">
                    <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                </form>
                <form action="../compartido/eliminarProveedor.php" method="POST" onsubmit="return confirmarEliminacionProveedor();">
                    <input type="hidden" name="tabla" value="Proveedor">
                    <input type="hidden" name="id" value="<?php echo $row['idProveedor']; ?>">
                    <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
                </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>

<script>
    function confirmarEliminacionProveedor() {
        return confirm("¿Estás seguro de que deseas eliminar este Proveedor?");
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Agregar el evento de clic al botón de búsqueda de Proveedor
        $("#buscar-Proveedor").click(function() {
            // Obtener el valor del campo de búsqueda de Proveedor
            var searchTerm = $("#ip-buscar-Proveedor").val();

            // Realizar la petición AJAX al servidor para buscar usuarios
            $.ajax({
                url: "../compartido/buscarProveedor.php", // Archivo PHP que manejará la búsqueda de usuarios
                method: "POST",
                data: { searchTerm: searchTerm }, // Enviar el término de búsqueda al servidor
                success: function(response) {
                    // Actualizar la tabla de usuarios con los resultados de la búsqueda
                    $("#Proveedor-tabla table").html(response);
                }
            });
        });
    });
</script>
    </div>
        </div>
            <?php include "../compartido/footer.php"; ?>
    </body>
</html>