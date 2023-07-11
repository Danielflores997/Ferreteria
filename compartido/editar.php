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

    // Aquí puedes agregar la lógica para guardar los cambios del producto
    $query = "UPDATE productos SET codigoProducto='$codigoProducto', nombreProductos='$nombreProducto', valorProducto=$valorProducto, stockProducto=$stockProducto, descripcionProducto='$descripcionProducto', nombreCategoria='$nombreCategoria' WHERE idProducto=$idProducto";

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

<h4>Editar Producto</h4>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
    <label for="codigo">Código:</label>
    <input type="text" name="codigo" value="<?php echo $codigoProducto; ?>"><br>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $nombreProducto; ?>"><br>
    <label for="valor">Precio:</label>
    <input type="number" name="valor" value="<?php echo $valorProducto; ?>"><br>
    <label for="stock">Cantidad:</label>
    <input type="number" name="stock" value="<?php echo $stockProducto; ?>"><br>
    <label for="descripcion">Descripción:</label>
    <input type="text" name="descripcion" value="<?php echo $descripcionProducto; ?>"><br>
    <label for="categoria">Categoría:</label>
    <select name="categoria">
        <?php foreach ($categorias as $idCategoria => $nombreCategoria) { ?>
            <option value="<?php echo $idCategoria; ?>" <?php if ($idCategoria == $nombreCategoria) echo "selected"; ?>><?php echo $nombreCategoria; ?></option>
        <?php } ?>
    </select><br>
    <button type="submit" name="guardar">Guardar Cambios</button>
</form>

