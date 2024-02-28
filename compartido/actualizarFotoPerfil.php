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
    // Redireccionar a perfil.php si la foto se actualizó correctamente
    header('Location: ../Php/vistaAdmin.php');
    exit;
} else {
    echo "Hubo un error al actualizar la foto de perfil.";
}

