<?php
if (!empty($_POST["registro"])) {
    if (empty($_POST["tipo_documento"]) or empty($_POST["documento"]) or empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["correo"]) or empty($_POST["contareña"]) or empty($_POST["confirmar"]) or empty($_POST["tratamiento-datos"])) {
        echo'uno de los campos esta vacio';
    } else {
        $tipoDoc=$_POST["tipo_documento"];
        $documeto=$_POST["documento"];
        $nombre=$_POST["nombre"];
        $apellido=$_POST["apellido"];
        $correo=$_POST["correo"];
        $contraseña=$_POST["contraseña"];
        $confirmar=$_POST["confirmar"];
        $tratamiento_datos=$_POST["tratamiento-datos"];
        $sql=$conexion->query("insert into usuario(tipoDocumentoUsuario,documentopUsuario,nombresUsuario,apellidosUsuario,correo,claveUsuario)values('$tipoDoc','$documeto','$nombre','$apellido','$correo','$contraseña') ");
        if ($sql==1) {
            echo'usuario registrado correctamente';
        } else {
            echo'error al registrar';
        }
        
    }
}
?>