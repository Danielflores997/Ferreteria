<?php
session_start();

function cerrarSesion() {
    session_destroy();
    header('Location: loginCliente.php');
    exit();
}

if (isset($_GET['logout'])) {
    cerrarSesion();
}

if (!isset($_SESSION['correo'])) {
    header('Location: loginCliente.php');
    exit();
}
?>


