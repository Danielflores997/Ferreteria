<?php
if (isset($_POST['guardar'])) {
    include "conexion.php";
    
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
    $query = "UPDATE cliente SET tipoDocumentoCliente='$tipoDocumento', documentoCliente='$identificacion', nombresCliente='$nombre', apellidosCliente='$apellido', telefonoCliente='$telefono', direccionCliente='$direccion', estadoCliente='$estado' WHERE idCliente=$idCliente";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error al guardar los cambios del cliente: " . mysqli_error($conn);
    } else {
        // Redirigir al usuario a la página de gestionarFuncionarios
        header("Location: ../Php/gestionarFuncionarios.php");
        exit();
    }
}

if (isset($_POST['editar'])) {
    include "conexion.php";

    $idCliente = $_POST['id'];

    // Aquí puedes agregar la lógica para recuperar los datos del cliente
    // correspondiente al ID proporcionado y cargarlos en un formulario de edición
    $query = "SELECT * FROM cliente WHERE idCliente=$idCliente";
    $result = mysqli_query($conn, $query);
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

<h4>Editar Cliente</h4>
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
    <label for="estado">Estado:</label>
    <select name="estado">
        <option value="Activo" <?php if ($estado == 'Activo') echo 'selected'; ?>>Activo</option>
        <option value="Inactivo" <?php if ($estado == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
    </select><br>
    <button type="submit" name="guardar">Guardar Cambios</button>
</form>
