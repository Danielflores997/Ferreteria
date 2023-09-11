<?php
include "conexion.php"; // Incluir el archivo de conexión

if (isset($_POST['guardar'])) {
    if (empty($_POST["codigo"]) || empty($_POST["producto"]) || empty($_POST["precio"]) || empty($_POST["cantidad"]) || empty($_POST["descripcion"]) || empty($_POST["categoria"]) || empty($_POST["imagen"])) {
        echo 'Uno de los campos está vacío';
    } else {
        $codigo = $_POST['codigo'];
        $producto = $_POST['producto'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $imagen_url = $_POST['imagen'];

        // Realizar la inserción en la base de datos
        $sql = "INSERT INTO productos (codigoProducto, nombreProductos, valorProducto, stockProducto, descripcionProducto, nombreCategoria, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssddsss", $codigo, $producto, $precio, $cantidad, $descripcion, $categoria, $imagen_url);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Nuevo producto agregado correctamente <a href="../Php/inventario.php">Actualizar inventario</a>';
        } else {
            echo 'Error al agregar el producto: ' . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt); // Cerrar la declaración preparada

    // Actualizar el inventario
    if (isset($_POST['actualizar'])) {
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];

        // Realizar la actualización del inventario
        $sql = "UPDATE productos SET stockProducto = stockProducto + $cantidad WHERE nombreProductos = '$producto'";
        if (mysqli_query($conn, $sql)) {
            echo "Inventario actualizado correctamente";
        } else {
            echo "Error al actualizar el inventario: " . mysqli_error($conn);
        }

        // Obtener los datos actualizados del inventario
        $sql = "SELECT nombreProductos, stockProducto FROM productos";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Inventario Actualizado</h2>";
            echo "<table>";
            echo "<tr><th>Producto</th><th>Cantidad</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row['nombreProductos'] . "</td><td>" . $row['stockProducto'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron registros en el inventario";
        }
    }

    mysqli_close($conn);
    }
}
?>


