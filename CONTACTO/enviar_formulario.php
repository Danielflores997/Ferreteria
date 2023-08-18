<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $motivo = $_POST['motivo'];

    echo "Muchas gracias por comunicarte. Nos pondremos en contacto a la brevedad posible.";
}
?>