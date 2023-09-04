<?php
include "conexion.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['Correo'];
    $contraseña = $_POST['Contraseña'];

    $conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");

    // Utilizar una sentencia preparada con marcadores de posición (?)
    $consulta = "SELECT * FROM usuario WHERE correo = ? AND claveUsuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ss", $correo, $contraseña);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $filas = mysqli_num_rows($resultado);

    if ($filas) {
        // Obtener los datos del usuario desde el resultado de la consulta
        $usuario = mysqli_fetch_assoc($resultado);
        $estadoUsuario = $usuario['estadoUsuario'];

        if ($estadoUsuario == 'Activo') {
            // El usuario está activo, permitir el acceso y redirigir según el rol
            $rol = $usuario['rol_idRol'];

            // Establecer la variable de sesión 'rol'
            $_SESSION['rol'] = $rol;

            if ($rol == 1) {
                header('Location: ../Php/vistaAdmin.php');
            } elseif ($rol == 2) {
                header('Location: ../Php/vistaAdmin.php');
            } else {
                header('Location: ../Php/loginCliente.php');
            }

            // Iniciar sesión y guardar el correo en la variable de sesión
            $_SESSION['correo'] = $correo;
        } else {
            // El usuario está inactivo, redirigir a una página de error o mostrar un mensaje de error
            header('Location: usuarioInactivo.php');
        }
    } else {
        header('Location: ../Php/loginCliente.php');
    }
}

if (isset($_GET['logout'])) {
    cerrarSesion();
}
?>





