<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/editarUsuario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Editar</title>
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
<?php
include "conexion.php";

if (isset($_POST['guardar'])) {
    $idProveedor = $_POST['id'];
    $nombreProveedor = isset($_POST['nombreProveedor']) ? $_POST['nombreProveedor'] : '';
    $apellidoProveedor = isset($_POST['apellidoProveedor']) ? $_POST['apellidoProveedor'] : '';
    $telefonoProveedor = isset($_POST['telefonoProveedor']) ? $_POST['telefonoProveedor'] : '';
    $direccionProveedor = isset($_POST['direccionProveedor']) ? $_POST['direccionProveedor'] : '';

    // Verificar si el número de identificación ya existe en la base de datos
    $queryVerificar = "SELECT idProveedor FROM proveedor WHERE idProveedor = ? AND nombreProveedor != ?";
    $stmtVerificar = mysqli_prepare($conn, $queryVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "is", $idProveedor, $nombreProveedor);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);

    if (mysqli_stmt_num_rows($stmtVerificar) > 0) {
        // El número de identificación ya está registrado, mostrar mensaje de error
        echo "El número de identificación ya está registrado.";
        exit();
    }

    // Si el número de identificación no está repetido, guardar los cambios del proveedor
    $query = "UPDATE proveedor SET idProveedor=?, nombreProveedor=?, apellidoProveedor=?, telefonoProveedor=?, direccionProveedor=? WHERE idProveedor=?";
    $stmtUpdate = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmtUpdate, "ssssss", $idProveedor, $nombreProveedor, $apellidoProveedor, $telefonoProveedor, $direccionProveedor, $idProveedor);
    mysqli_stmt_execute($stmtUpdate);

    // Redirigir al usuario a la página de gestionarProveedor
    header("Location: ../Php/gestionarProveedores.php");
    exit();
}

if (isset($_POST['editar'])) {
    $idProveedor = $_POST['id'];

    // Aquí puedes agregar la lógica para recuperar los datos del proveedor
    // correspondiente al ID proporcionado y cargarlos en un formulario de edición
    $query = "SELECT * FROM proveedor WHERE idProveedor=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idProveedor);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Variables para almacenar los valores actuales del proveedor
    $idProveedor = $row['idProveedor'];
    $nombreProveedor = $row['nombreProveedor'];
    $apellidoProveedor = $row['apellidoProveedor'];
    $telefonoProveedor = $row['telefonoProveedor'];
    $direccionProveedor = $row['direccionProveedor'];
    $correoProveedor = $row['correoProveedor'];
}
?>

<!-- Formulario HTML -->
<h4 id="titulo-tabla">Editar proveedor</h4>
<form action="../compartido/editarProveedor.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $idProveedor; ?>">
    <label for="identificacion">Identificación:</label>
    <input type="text" name="idProveedor" value="<?php echo $idProveedor; ?>"><br>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombreProveedor" value="<?php echo $nombreProveedor; ?>"><br>
    <label for="apellido">Apellido:</label>
    <input type="text" name="apellidoProveedor" value="<?php echo $apellidoProveedor; ?>"><br>
    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefonoProveedor" value="<?php echo $telefonoProveedor; ?>"><br>
    <label for="direccion">Dirección:</label>
    <input type="text" name="direccionProveedor" value="<?php echo $direccionProveedor; ?>"><br>
    <button type="submit" name="guardar">Guardar Cambios</button>
</form>
<?php include "../compartido/footer.php"; ?>
</body>
</html>
