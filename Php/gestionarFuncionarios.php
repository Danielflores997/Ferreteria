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
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
            </div>
            <div class="nom-usuario">
                <!-- Aquí puedes mostrar el correo del usuario -->
                <?php
                    if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido:<br>" . $_SESSION['correo'] . "</h3>";
                    }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
        </div>

        <div class="inventario">
        <h4 id="usuarios-titulo-tabla">Usuarios</h4>
<div id="buscar">
    <button id="buscar-usuarios"><i class="fa-solid fa-magnifying-glass"></i></button>
    <input id="ip-buscar-usuarios" type="text">
</div>
<div id="usuarios-tabla">
    <table>
        <tr>
            <th id="celda-principal">Tipo Documento</th>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Correo</th>
            <th id="celda-principal">Estado</th>
            <th id="celda-principal">Rol</th>
            <th id="celda-principal">Acciones</th>
        </tr>
        <?php
        include "../compartido/conexion.php";

        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM usuario";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error al obtener los usuarios: " . mysqli_error($conn);
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['tipoDocumentoUsuario']; ?></td>
                <td><?php echo $row['documentoUsuario']; ?></td>
                <td><?php echo $row['nombresUsuario']; ?></td>
                <td><?php echo $row['apellidosUsuario']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['estadoUsuario']; ?></td>
                <td><?php echo $row['rol_idRol']; ?></td>
                <td class="acciones">
                <form action="../compartido/editarUsuario.php" method="POST">
                    <input type="hidden" name="tabla" value="usuario">
                    <input type="hidden" name="id" value="<?php echo $row['idUsuario']; ?>">
                    <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                </form>
                <form action="../compartido/eliminarUsuario.php" method="POST" onsubmit="return confirmarEliminacionUsuario();">
                    <input type="hidden" name="tabla" value="usuario">
                    <input type="hidden" name="id" value="<?php echo $row['idUsuario']; ?>">
                    <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
                </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>

<div class="clientes-tabla">
    <h4 id="clientes-titulo-tabla">Clientes</h4>
    <div id="buscar">
    <button id="buscar-clientes"><i class="fa-solid fa-magnifying-glass"></i></button>
        <input id="ip-buscar-clientes" type="text">
    </div>
    <div id="clientes-tabla">
    <table>
        <tr>
            <th id="celda-principal">Tipo Documento</th>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Telefono</th>
            <th id="celda-principal">Direccion</th>
            <th id="celda-principal">Estado</th>
            <th id="celda-principal">Acciones</th>
        </tr>
        <?php
        include "../compartido/conexion.php";

        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM cliente";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error al obtener los clientes : " . mysqli_error($conn);
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['tipoDocumentoCliente']; ?></td>
                <td><?php echo $row['documentoCliente']; ?></td>
                <td><?php echo $row['nombresCliente']; ?></td>
                <td><?php echo $row['apellidosCliente']; ?></td>
                <td><?php echo $row['telefonoCliente']; ?></td>
                <td><?php echo $row['direccionCliente']; ?></td>
                <td><?php echo $row['estadoCliente']; ?></td>
                <td class="acciones">
            <form action="../compartido/editarCliente.php" method="POST">
                <input type="hidden" name="tabla" value="cliente">
                <input type="hidden" name="id" value="<?php echo $row['idCliente']; ?>">
                <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
            </form>
            <form action="../compartido/eliminarCliente.php" method="POST" onsubmit="return confirmarEliminacionCliente();">
                <input type="hidden" name="tabla" value="cliente">
                <input type="hidden" name="id" value="<?php echo $row['idCliente']; ?>">
                <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
            </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    </div>
</div>
<script>
    function confirmarEliminacionUsuario() {
        return confirm("¿Estás seguro de que deseas eliminar este usuario?");
    }

    function confirmarEliminacionCliente() {
        return confirm("¿Estás seguro de que deseas eliminar este cliente?");
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Agregar el evento de clic al botón de búsqueda de usuarios
        $("#buscar-usuarios").click(function() {
            // Obtener el valor del campo de búsqueda de usuarios
            var searchTerm = $("#ip-buscar-usuarios").val();

            // Realizar la petición AJAX al servidor para buscar usuarios
            $.ajax({
                url: "../compartido/buscarUsuario.php", // Archivo PHP que manejará la búsqueda de usuarios
                method: "POST",
                data: { searchTerm: searchTerm }, // Enviar el término de búsqueda al servidor
                success: function(response) {
                    // Actualizar la tabla de usuarios con los resultados de la búsqueda
                    $("#usuarios-tabla table").html(response);
                }
            });
        });

        // Agregar el evento de clic al botón de búsqueda de clientes
        $("#buscar-clientes").click(function() {
            // Obtener el valor del campo de búsqueda de clientes
            var searchTerm = $("#ip-buscar-clientes").val();

            // Realizar la petición AJAX al servidor para buscar clientes
            $.ajax({
                url: "../compartido/buscarCliente.php", // Archivo PHP que manejará la búsqueda de clientes
                method: "POST",
                data: { searchTerm: searchTerm }, // Enviar el término de búsqueda al servidor
                success: function(response) {
                    // Actualizar la tabla de clientes con los resultados de la búsqueda
                    $("#clientes-tabla table").html(response);
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