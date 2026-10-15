<?php
include "conexion.php";

if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    $conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");
    
    // Desactivar restricciones de clave externa
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0");

    // Realizar la eliminación del usuario en la tabla 'usuario'
    $consulta = "DELETE FROM usuario WHERE idUsuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Volver a activar restricciones de clave externa
    mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1");

    // Verificar si se ha eliminado algún registro
    $filas_afectadas = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($filas_afectadas > 0) {
        // Redirigir al usuario a la página de funcionarios después de eliminar el Usuario
        header("Location: ../Php/gestionarFuncionarios.php?mensaje=Usuario eliminado exitosamente");
        exit();
    } else {
        // Si no se eliminó ningún usuario, redirigir al usuario a la página de funcionarios con un mensaje de error
        header("Location: ../Php/gestionarFuncionarios.php?error=No se pudo eliminar el Usuario");
        exit();
    }
} else {
    // Si no se ha enviado el formulario de eliminación, redirigir al usuario a la página de funcionarios
    header("Location: ../Php/gestionarFuncionarios.php");
    exit();
}
?>