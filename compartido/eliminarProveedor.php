<?php
include "conexion.php";

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    $conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");
    
    // Desactivar restricciones de clave externa
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0");

    // Realizar la eliminación del cliente en la tabla 'cliente'
    $consulta = "DELETE FROM proveedor WHERE idProveedor = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Volver a activar restricciones de clave externa
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1");

    // Verificar si se ha eliminado algún registro
    $filas_afectadas = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($filas_afectadas > 0) {
        // Redirigir al cliente a la página de Proveedores después de eliminar el Cliente
        header("Location: ../Php/gestionarProveedores.php?mensaje=cliente eliminado exitosamente");
        exit();
    } else {
        // Si no se eliminó ningún Cliente, redirigir al cliente a la página de Proveedor con un mensaje de error
        header("Location: ../Php/gestionarProveedores.php?error=No se pudo eliminar el Proveedor");
        exit();
    }
} else {
    // Si no se ha enviado el formulario de eliminación, redirigir al cliente a la página del Proveedor
    header("Location: ../Php/gestionarProveedores.php");
    exit();
}
?>