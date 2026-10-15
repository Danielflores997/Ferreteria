<?php
include "conexion.php";

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    $conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");
    
    // Desactivar restricciones de clave externa
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0");

    // Realizar la eliminación del producto en la tabla 'productos'
    $consulta = "DELETE FROM productos WHERE idProducto = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Volver a activar restricciones de clave externa
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1");

    // Verificar si se ha eliminado algún registro
    $filas_afectadas = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($filas_afectadas > 0) {
        // Redirigir al usuario a la página de inventario después de eliminar el producto
        header("Location: ../Php/inventario.php?mensaje=Producto eliminado exitosamente");
        exit();
    } else {
        // Si no se eliminó ningún registro, redirigir al usuario a la página de inventario con un mensaje de error
        header("Location: ../Php/inventario.php?error=No se pudo eliminar el producto");
        exit();
    }
} else {
    // Si no se ha enviado el formulario de eliminación, redirigir al usuario a la página de inventario
    header("Location: ../Php/inventario.php");
    exit();
}
?>



