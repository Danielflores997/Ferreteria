<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['Correo']);
    $contraseña = trim($_POST['Contraseña']);

    // Utilizar sentencias preparadas para evitar inyección SQL
    $consulta = "SELECT * FROM usuario WHERE correo=?";
    $stmt = mysqli_prepare($conn, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificar la contraseña almacenada
        $claveUsuario = $usuario['claveUsuario'];

        if (password_verify($contraseña, $claveUsuario)) {
            // Inicio de sesión exitoso, redirigir a otro enlace
            header('Location: ../Php/inventario.php');
            exit();
        } else {
            // Contraseña incorrecta
            header('Location: ../Php/loginCliente.php?error=Contraseña incorrecta');
            exit();
        }
    } else {
        // No se encontró el usuario en la base de datos
        header('Location: ../Php/loginCliente.php?error=El usuario no existe');
        exit();
    }
}
?>


