<?php
include "conexion.php"; 

if (isset($_POST['guardar'])) {
    if (empty($_POST["id"]) || empty($_POST["producto"]) || empty($_POST["precio"]) || empty($_POST["cantidad"]) || empty($_POST["descripcion"]) || empty($_POST["categoria"]) || empty($_POST["imagen"])) {
        echo 'Uno de los campos está vacío';
        echo $_POST["id"] + " - ";
        echo $_POST["producto"] + " - ";
        echo $_POST["precio"] + " - ";
        echo $_POST["cantidad"] + " - ";
        echo $_POST["descripcion"] + " - ";
        echo $_POST["imagen"];
    } else {
                $idcodigo = $_POST['id'];
                $producto = $_POST['producto'];
                $precio_unitario = $_POST['precio'];
                $cantidad = $_POST['cantidad'];
                $descripcion = $_POST['descripcion'];
                $categoria = $_POST['categoria'];
                $imagen_url = $_POST['imagen'];

        $sql = "INSERT INTO ventas (idcodigo, producto, precio_unitario, cantidad, descripcion, Categoria, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssddsss", $idcodigo, $producto, $precio_unitario, $cantidad, $descripcion, $categoria, $imagen_url);

        if (mysqli_stmt_execute($stmt)) {

            header("Location: ../Php/ventas.php?mensaje=venta agregado exitosamente");
            exit();
        } else {
            header("Location: ../Php/Ventas.php?error=No se pudo registrar la venta ");
            exit();
        }

        mysqli_stmt_close($stmt); 

    if (isset($_POST['actualizar'])) {
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];

        $sql = "UPDATE ventas SET cantidad = cantidad + $cantidad WHERE producto = '$producto'";
        if (mysqli_query($conn, $sql)) {
            echo "venta actualizado correctamente";
        } else {
            echo "Error al actualizar el venta: " . mysqli_error($conn);
        }

        $sql = "SELECT cantidad ,producto  FROM ventas";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>venta Actualizado</h2>";
            echo "<table>";
            echo "<tr><th>Producto</th><th>Cantidad</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row['producto'] . "</td><td>" . $row['cantidad'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron registros en el venta";
        }
    }

    mysqli_close($conn);
    }
}
?>


