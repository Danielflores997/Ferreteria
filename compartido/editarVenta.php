<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/editar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Editar</title>
</head>

<body>
    <div class="encabezado">
        <header>
            <div class="titulo">
                <h1>FERRETERIA MEISSEN</h1>
            </div>
            <div class="logo">
                <img src="../imagenes/ferreteria.jpeg" alt="logo ferreteria">
            </div>
        </header>
        <nav class="navbar">
            <div class="lista">
                <button class="btn-login">
                    <a class="btn-login" href="../compartido/cerrarSesion.php">Cerrar Sesión</a>
                </button>
            </div>
        </nav>
    </div>
    <?php
    include "conexion.php";

    $queryCategorias = "SELECT * FROM categoria";
    $resultCategorias = mysqli_query($conn, $queryCategorias);
    if (!$resultCategorias) {
        echo "Error al obtener las categorías: " . mysqli_error($conn);
    }

    $categorias = array();
    while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
        $categorias[$rowCategoria['idCategoria']] = $rowCategoria['nombreCategoria'];
    }

    if (isset($_POST['guardar'])) {
        $idVenta = $_POST['id'];
        $producto = $_POST['producto'];
        $precio_unitario = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $codigoProducto = $_POST['codigoProducto'];
    
        // Actualizar venta en la base de datos
        $query = "UPDATE ventas SET producto='$producto', precio_unitario='$precio_unitario', cantidad='$cantidad', descripcion='$descripcion', Categoria='$categoria' WHERE idVenta=$idVenta";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Error al guardar los cambios del producto: " . mysqli_error($conn);
        } else {
            // Actualizar el stock del producto en la tabla de productos
            $queryUpdateStock = "UPDATE productos SET stockProducto = stockProducto - $cantidad WHERE codigoProducto = '$codigoProducto'";
            $resultUpdateStock = mysqli_query($conn, $queryUpdateStock);
            if (!$resultUpdateStock) {
                echo "Error al actualizar el stock del producto: " . mysqli_error($conn);
            } else {
                header("Location: ../Php/ventas.php");
                exit();
            }
        }
    }    

    if (isset($_POST['editar'])) {
        $idVenta = $_POST['id'];

        $query = "SELECT * FROM ventas WHERE idVenta=$idVenta";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $idVenta = $row['idVenta'];
        $producto = $row['producto'];
        $precio_unitario = $row['precio_unitario'];
        $cantidad = $row['cantidad'];
        $descripcion = $row['descripcion'];
        $categoria = $row['Categoria'];
    }
    ?>

    <h4 id="titulo-tabla">Editar Venta</h4>
    <div class="contenedorfor">
        <form class="forEditar" action="" method="POST">
            <div>
                <input type="hidden" name="id" value="<?php echo $idVenta; ?>"><br>
            </div>
            <div>
                <label for="producto">producto:</label>
                <input type="text" id="producto" name="producto" value="<?php echo $producto; ?>"><br>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio" value="<?php echo $precio_unitario; ?>"><br>
            </div>
            <div>
                <label for="cantidad">Cantidad:</label>
                <input type="text" id="cantidad" name="cantidad" value="<?php echo $cantidad; ?>"><br>
            </div>
            <div>
                <label for="descripcion">descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>"><br>
            </div>
            <div>
                <label for="categoria">categoria:</label>
                <select name="categoria">
                    <?php foreach ($categorias as $idCategoria => $nombreCategoria) { ?>
                        <option value="<?php echo $idCategoria; ?>" <?php if ($idCategoria == $categoria) echo "selected"; ?>><?php echo $nombreCategoria; ?></option>
                    <?php } ?>
                </select><br>
            </div>
            <div>
                <button type="submit" name="guardar">Guardar Cambios</button>
            </div>
        </form>
    </div>
    <?php include "../compartido/footer.php"; ?>
</body>

</html>
