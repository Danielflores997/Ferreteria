<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); // Redirigir si el usuario no ha iniciado sesión
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
    $idCliente = $_POST['id'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];

    // Verificar si el número de identificación ya existe en la base de datos
    $queryVerificar = "SELECT idCliente FROM cliente WHERE documentoCliente = ? AND idCliente != ?";
    $stmtVerificar = mysqli_prepare($conn, $queryVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "si", $identificacion, $idCliente);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);

    if (mysqli_stmt_num_rows($stmtVerificar) > 0) {
        // El número de identificación ya está registrado, mostrar mensaje de error
        echo "El número de identificación ya está registrado.";
        exit();
    }

    // Si el número de identificación no está repetido, guardar los cambios del cliente
    $query = "UPDATE cliente SET tipoDocumentoCliente=?, documentoCliente=?, nombresCliente=?, apellidosCliente=?, telefonoCliente=?, direccionCliente=?, estadoCliente=? WHERE idCliente=?";
    $stmtUpdate = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmtUpdate, "sssssssi", $tipoDocumento, $identificacion, $nombre, $apellido, $telefono, $direccion, $estado, $idCliente);
    mysqli_stmt_execute($stmtUpdate);

    // Actualizar la contraseña solo si se proporciona una nueva contraseña
    if (!empty($_POST['nuevaContraseña'])) {
        $nuevaContraseña = $_POST['nuevaContraseña'];
        $queryUpdateContraseña = "UPDATE cliente SET passwordCliente=? WHERE idCliente=?";
        $stmtUpdateContraseña = mysqli_prepare($conn, $queryUpdateContraseña);
        mysqli_stmt_bind_param($stmtUpdateContraseña, "si", $nuevaContraseña, $idCliente);
        mysqli_stmt_execute($stmtUpdateContraseña);
    }

    // Redirigir al usuario a la página de gestionarFuncionarios
    header("Location: ../Php/gestionarFuncionarios.php");
    exit();
}

if (isset($_POST['editar'])) {
    $idCliente = $_POST['id'];

    // Aquí puedes agregar la lógica para recuperar los datos del cliente
    // correspondiente al ID proporcionado y cargarlos en un formulario de edición
    $query = "SELECT * FROM cliente WHERE idCliente=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $idCliente);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Variables para almacenar los valores actuales del cliente
    $tipoDocumento = $row['tipoDocumentoCliente'];
    $identificacion = $row['documentoCliente'];
    $nombre = $row['nombresCliente'];
    $apellido = $row['apellidosCliente'];
    $telefono = $row['telefonoCliente'];
    $direccion = $row['direccionCliente'];
    $estado = $row['estadoCliente'];
}
?>

<!-- Formulario HTML -->
<h4 id="titulo-tabla">Editar Cliente</h4>
<form action="../compartido/editarCliente.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $idCliente; ?>">
    <label for="tipoDocumento">Tipo Documento:</label>
    <input type="text" name="tipoDocumento" value="<?php echo $tipoDocumento; ?>"><br>
    <label for="identificacion">Identificación:</label>
    <input type="text" name="identificacion" value="<?php echo $identificacion; ?>"><br>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombre; ?>"><br>
    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" value="<?php echo $apellido; ?>"><br>
    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo $telefono; ?>"><br>
    <label for="direccion">Dirección:</label>
    <input type="text" name="direccion" value="<?php echo $direccion; ?>"><br>
    <label for="nuevaContraseña">Nueva Contraseña:</label>
    <input type="text" name="nuevaContraseña" value=""><br>
    <label for="estado">Estado:</label>
    <select name="estado">
        <option value="Activo" <?php if ($estado == 'Activo') echo 'selected'; ?>>Activo</option>
        <option value="Inactivo" <?php if ($estado == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
    </select><br>
    <button type="submit" name="guardar">Guardar Cambios</button>
</form>
<?php include "../compartido/footer.php"; ?>
</body>
</html>
