<?php
include "conexion.php";

session_start();

$correo = $_SESSION['correo'];

$conexion = mysqli_connect("localhost", "root", "", "ferreterianuevo");

// Obtener el enlace de la imagen de perfil enviado por el formulario
$nuevo_enlace = $_POST['foto'];

// Actualizar la foto de perfil en la base de datos
$consulta_actualizar = "UPDATE usuario SET fotoPerfil = ? WHERE correo = ?";
$stmt_actualizar = mysqli_prepare($conexion, $consulta_actualizar);
mysqli_stmt_bind_param($stmt_actualizar, "ss", $nuevo_enlace, $correo);
$resultado_actualizar = mysqli_stmt_execute($stmt_actualizar);

if ($resultado_actualizar) {
    // Obtener el rol del usuario después de actualizar la foto
    $consulta_obtener_rol = "SELECT rol_idRol FROM usuario WHERE correo = ?";
    $stmt_obtener_rol = mysqli_prepare($conexion, $consulta_obtener_rol);
    mysqli_stmt_bind_param($stmt_obtener_rol, "s", $correo);
    mysqli_stmt_execute($stmt_obtener_rol);
    $resultado_obtener_rol = mysqli_stmt_get_result($stmt_obtener_rol);
    $usuario = mysqli_fetch_assoc($resultado_obtener_rol);
    $rol = $usuario['rol_idRol'];

    // Redireccionar según el rol
    if ($rol == 0) {
        header('Location: ../Php/perfilCliente.php');
    } else {
        header('Location: ../Php/vistaAdmin.php');
    }
    exit;
} else {
    echo '<div class ="mensajes-alertas">Hubo un error al actualizar la foto de perfil
    <div class ="mensaje-boton"><a href="../Php/perfilCliente.php">Aceptar</a>
    </div>
</div>';
}


