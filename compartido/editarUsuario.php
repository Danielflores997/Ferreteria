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

// Obtener las categorías de la base de datos
$queryCategorias = "SELECT * FROM categoria";
$resultCategorias = mysqli_query($conn, $queryCategorias);
if (!$resultCategorias) {
    echo "Error al obtener las categorías: " . mysqli_error($conn);
}

$categorias = array();
while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
    $categorias[$rowCategoria['idCategoria']] = $rowCategoria['nombreCategoria'];
}

if (isset($_POST['guardar'])) {
    $idUsuario = $_POST['id'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $rol = $_POST['rol'];

    // Verificar si el número de identificación ya existe en la base de datos
    $queryVerificar = "SELECT idUsuario FROM usuario WHERE documentopUsuario = ? AND idUsuario != ?";
    $stmtVerificar = mysqli_prepare($conn, $queryVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "si", $identificacion, $idUsuario);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);

    if (mysqli_stmt_num_rows($stmtVerificar) > 0) {
        // El número de identificación ya está registrado, mostrar mensaje de error
        echo "El número de identificación ya está registrado.";
        exit();
    }

    // Si el número de identificación no está repetido, guardar los cambios del usuario
    $query = "UPDATE usuario SET tipoDocumentoUsuario='$tipoDocumento', documentopUsuario='$identificacion', nombresUsuario='$nombre', apellidosUsuario='$apellido', correo='$correo', estadoUsuario='$estado', rol_idRol=$rol WHERE idUsuario=$idUsuario";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error al guardar los cambios del usuario: " . mysqli_error($conn);
    } else {
        // Redirigir al usuario a la página de gestionarFuncionarios
        header("Location: ../Php/gestionarFuncionarios.php");
        exit();
    }
}

if (isset($_POST['editar'])) {
    $idUsuario = $_POST['id'];

    // Aquí puedes agregar la lógica para recuperar los datos del usuario
    // correspondiente al ID proporcionado y cargarlos en un formulario de edición
    $query = "SELECT * FROM usuario WHERE idUsuario=$idUsuario";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Variables para almacenar los valores actuales del usuario
    $tipoDocumento = $row['tipoDocumentoUsuario'];
    $identificacion = $row['documentopUsuario'];
    $nombre = $row['nombresUsuario'];
    $apellido = $row['apellidosUsuario'];
    $correo = $row['correo'];
    $estado = $row['estadoUsuario'];
    $rol = $row['rol_idRol'];
}
?>

<h4 id="titulo-tabla">Editar Usuario</h4>
<form action="../compartido/editarUsuario.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $idUsuario; ?>">
    <label for="tipoDocumento">Tipo Documento:</label>
    <input type="text" name="tipoDocumento" value="<?php echo $tipoDocumento; ?>"><br>
    <label for="identificacion">Identificación:</label>
    <input type="text" name="identificacion" value="<?php echo $identificacion; ?>"><br>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombre; ?>"><br>
    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" value="<?php echo $apellido; ?>"><br>
    <label for="correo">Correo:</label>
    <input type="text" name="correo" value="<?php echo $correo; ?>"><br>
    <label for="rol">Rol:</label>
    <input type="text" name="rol" value="<?php echo $rol; ?>"><br>
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
