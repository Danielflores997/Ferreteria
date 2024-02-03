<?php

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}

include "../compartido/conexion.php";

$queryCategorias = "SELECT * FROM categoria";
$resultCategorias = mysqli_query($conn, $queryCategorias);

if (!$resultCategorias) {
    echo "Error al obtener las categorías: " . mysqli_error($conn);
}

$categorias = array();
while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
    $categorias[$rowCategoria['idCategoria']] = $rowCategoria['nombreCategoria'];
}

if (isset($_POST['editar'])) {
    $idProducto = $_POST['id'];

    $query = "SELECT * FROM ventas WHERE idcodigo=$idcodigo";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $producto = $row['producto'];
    $precio_unitario = $row['precio'];
    $cantidad = $row['cantidad'];
    $descripcion = $row['descripcion'];
    $categoria = $row['categoria'];
}

if (isset($_POST['guardar'])) {
    include "editarVenta.php";
} else {

    $query = "SELECT * FROM Ventas";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al obtener los productos: " . mysqli_error($conn);
    }
    ?>

    <h4 id="titulo-tabla">Ventas</h4>
    <div id="tabla">
        <table>
            <tr>
                <th id="celda-principal">id</th>
                <th id="celda-principal">Producto</th>
                <th id="celda-principal">Precio</th>
                <th id="celda-principal">Cantidad</th>
                <th id="celda-principal">Descripción</th>
                <th id="celda-principal">Categoría</th>
                <th id="celda-principal">Acciones</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['idcodigo']; ?></td>
                    <td><?php echo $row['producto']; ?></td>
                    <td><?php echo $row['precio_unitario']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td>
                        <?php foreach ($categorias as $idCategoria => $nombreCategoria) { ?>
                            <?php if ($idCategoria == $row['Categoria']) echo $nombreCategoria ?>
                        <?php } ?>
                    </td>
                    <td class="acciones">
                        <form action="../compartido/editarVenta.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['idcodigo']; ?>">
                            <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                        </form>
                        <form action="../compartido/eliminarVenta.php" method="POST" onsubmit="return confirmarEliminacion();">
                            <input type="hidden" name="id" value="<?php echo $row['idcodigo']; ?>">
                            <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este producto?");
        }
    </script>

<?php
}
?>
