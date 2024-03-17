<?php
session_start();

// Verificar si el formulario se envió correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['correo'])) {
        echo "Error: Debes iniciar sesión para realizar una compra.";
        exit();
    }

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "ferreterianuevo");

    // Verificar la conexión
    if ($conexion->connect_error) {
        echo "Error de conexión: " . $conexion->connect_error;
        exit();
    }

    // Obtener el correo electrónico de la sesión
    $correo_usuario = $_SESSION['correo'];

    // Consulta para obtener el usuario_id basado en el correo electrónico de la sesión
    $consulta_usuario = "SELECT idUsuario FROM usuario WHERE correo = ?";
    $declaracion_usuario = $conexion->prepare($consulta_usuario);
    $declaracion_usuario->bind_param("s", $correo_usuario);
    $declaracion_usuario->execute();
    $resultado_usuario = $declaracion_usuario->get_result();

    // Verificar si se encontró el usuario
    if ($resultado_usuario->num_rows == 0) {
        echo "Error: No se encontró el usuario.";
        exit();
    }

    // Obtener el usuario_id
    $fila_usuario = $resultado_usuario->fetch_assoc();
    $usuario_id = $fila_usuario['idUsuario'];

    // Obtener los productos del formulario
    $productos = json_decode($_POST['productos'], true);

    // Preparar y ejecutar la consulta para insertar cada producto en la tabla de compras
    foreach ($productos as $producto) {
        $producto_id = $producto['idProducto'] ?? null; // Se agrega un valor predeterminado en caso de que no se envíe el idProducto
        $cantidad = $producto['cantidad'];
        $fecha = date("Y-m-d H:i:s");

        $consulta = "INSERT INTO compras (usuario_id, producto_id, cantidad, fecha) VALUES (?, ?, ?, ?)";
        $declaracion = $conexion->prepare($consulta);
        $declaracion->bind_param("iiis", $usuario_id, $producto_id, $cantidad, $fecha);
        $declaracion->execute();

        // Verificar si se insertó correctamente
        if ($declaracion->affected_rows <= 0) {
            echo "Error al procesar la compra.";
            $declaracion->close();
            $conexion->close();
            exit();
        }

        $declaracion->close();
    }

    // Cerrar la conexión
    $conexion->close();

    // Mostrar mensaje de compra exitosa
    echo "¡Compra exitosa! Gracias por tu compra.";
} else {
    echo "Error: El formulario de compra no se envió correctamente.";
}
?>
