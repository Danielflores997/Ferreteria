<?php
include "conexion.php";

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
        header('Location: ../Php/vistaCatalogo.php');
    } else {
        header('Location: ../Php/loginCliente.php');
    }
}
?>




