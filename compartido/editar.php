<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); // Redirigir si el usuario no ha iniciado sesión
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

// Obtener las categorías de la base de datos
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
    $idProducto = $_POST['id'];
    $codigoProducto = $_POST['codigo'];
    $nombreProducto = $_POST['nombre'];
    $valorProducto = $_POST['valor'];
    $stockProducto = $_POST['stock'];
    $descripcionProducto = $_POST['descripcion'];
    $nombreCategoria = $_POST['categoria'];

    // Nueva ruta de imagen ingresada por el usuario
    $nuevaRutaImagen = $_POST['imagen'];

    // Aquí puedes agregar la lógica para guardar los cambios del producto
    $query = "UPDATE productos SET codigoProducto='$codigoProducto', nombreProductos='$nombreProducto', valorProducto=$valorProducto, stockProducto=$stockProducto, descripcionProducto='$descripcionProducto', nombreCategoria='$nombreCategoria', imagen='$nuevaRutaImagen' WHERE idProducto=$idProducto";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error al guardar los cambios del producto: " . mysqli_error($conn);
    } else {
        // Redirigir al usuario a la página de inventario
        header("Location: ../Php/inventario.php");
        exit();
    }
}

if (isset($_POST['editar'])) {
    $idProducto = $_POST['id'];

    // Aquí puedes agregar la lógica para recuperar los datos del producto
    // correspondiente al ID proporcionado y cargarlos en un formulario de edición
    $query = "SELECT * FROM productos WHERE idProducto=$idProducto";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Variables para almacenar los valores actuales del producto
    $codigoProducto = $row['codigoProducto'];
    $nombreProducto = $row['nombreProductos'];
    $valorProducto = $row['valorProducto'];
    $stockProducto = $row['stockProducto'];
    $descripcionProducto = $row['descripcionProducto'];
    $nombreCategoria = $row['nombreCategoria'];
}
?>

<h4 id="titulo-tabla">Editar Producto</h4>
<div class="contenedorfor">
<form class ="forEditar" action="" method="POST">
    <div>
    <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
    <label for="codigo">Código:</label>
    </div>
    <div>
    <input type="text" name="codigo" value="<?php echo $codigoProducto; ?>"><br>
    <label for="nombre">Nombre:</label>
    </div>
    <div>
    <input type="text" name="nombre" value="<?php echo $nombreProducto; ?>"><br>
    <label for="valor">Precio:</label>
    </div>
    <div>
    <input type="number" name="valor" value="<?php echo $valorProducto; ?>"><br>
    <label for="stock">Cantidad:</label>
    </div>
    <div>
    <input type="number" name="stock" value="<?php echo $stockProducto; ?>"><br>
    <label for="descripcion">Descripción:</label>
    </div>
    <div>
    <input type="text" name="descripcion" value="<?php echo $descripcionProducto; ?>"><br>
    <label for="categoria">Categoría:</label>
    </div>
    <div>
    <select name="categoria">
        <?php foreach ($categorias as $idCategoria => $nombreCategoria) { ?>
            <option value="<?php echo $idCategoria; ?>" <?php if ($idCategoria == $nombreCategoria) echo "selected"; ?>><?php echo $nombreCategoria; ?></option>
        <?php } ?>
    </select><br>
    </div>
    <div>
        <label for="imagen">Imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?php echo $row['imagen']; ?>" placeholder="Nueva ruta de imagen">
    </div>
    <div>
    <button type="submit" name="guardar">Guardar Cambios</button>
    </div>
</form>
</div>
<?php include "../compartido/footer.php"; ?>
</body>
</html>