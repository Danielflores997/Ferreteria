<?php
include "conexion.php";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Realizar la consulta a la base de datos con la condición de búsqueda
    $query = "SELECT * FROM productos WHERE codigoProducto LIKE '%$searchTerm%' OR nombreProductos LIKE '%$searchTerm%' OR
    stockProducto LIKE '%$searchTerm%' OR nombreCategoria LIKE '%$searchTerm%'";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al obtener los productos: " . mysqli_error($conn);
    } else {
        // Construir la tabla con los resultados de la búsqueda
        $table = '';

        // Bandera para verificar si ya se ha impreso el encabezado
        $encabezadoImpreso = false;

        while ($row = mysqli_fetch_assoc($result)) {
            // Imprimir encabezado solo si no se ha impreso antes
            if (!$encabezadoImpreso) {
                $table .= '<tr>
                    <th id="celda-principal">Código</th>
                    <th id="celda-principal">Producto</th>
                    <th id="celda-principal">Precio</th>
                    <th id="celda-principal">Cantidad</th>
                    <th id="celda-principal">Descripción</th>
                    <th id="celda-principal">Categoría</th>
                </tr>';
                // Marcar la bandera como true para que no se imprima de nuevo
                $encabezadoImpreso = true;
            }

            $idProducto = $row['idProducto'];
            $table .= '<tr>
                <td>' . $row['codigoProducto'] . '</td>
                <td>' . $row['nombreProductos'] . '</td>
                <td>' . $row['valorProducto'] . '</td>
                <td>' . $row['stockProducto'] . '</td>
                <td>' . $row['descripcionProducto'] . '</td>
                <td>' . $row['nombreCategoria'] . '</td>
            </tr>';
        }
        echo $table;
    }
}
?>
<script>
    function confirmarEliminacion() {
        return confirm("¿Estás seguro de que deseas eliminar este producto?");
    }
</script>

