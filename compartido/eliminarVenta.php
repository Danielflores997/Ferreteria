<?php
include "conexion.php";

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    $conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");
    

    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0");

    $consulta = "DELETE FROM ventas WHERE idVenta = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1");


    $filas_afectadas = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($filas_afectadas > 0) {

        header("Location: ../Php/ventas.php?mensaje=venta eliminada exitosamente");
        exit();
    } else {
        
        header("Location: ../Php/Ventas.php?error=No se pudo eliminar la venta");
        exit();
    }
} else {
    // Si no se ha enviado el formulario de eliminación, redirigir al usuario a la página de 
    header("Location: ../Php/ventas.php");
    exit();
}
?>



