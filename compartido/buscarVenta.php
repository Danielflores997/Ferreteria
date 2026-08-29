<?php
include "conexion.php";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    $query = "SELECT * FROM ventas WHERE idVenta LIKE '%$searchTerm%' OR idcodigo LIKE '%$searchTerm%' OR producto LIKE '%$searchTerm%' OR
    precio_unitario LIKE '%$searchTerm%' OR cantidad LIKE '%$searchTerm%' OR Categoria LIKE '%$searchTerm%' OR fecha_venta LIKE '%$searchTerm%'";
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al obtener las ventas: " . mysqli_error($conn);
    } else {
        // Construir la tabla con los resultados de la búsqueda
        $table = '';

        // Bandera para verificar si ya se ha impreso el encabezado
        $encabezadoImpreso = false;

        while ($row = mysqli_fetch_assoc($result)) {
            // Imprimir encabezado solo si no se ha impreso antes
            if (!$encabezadoImpreso) {
                $table .= '<tr>
                    <th id="celda-principal">Id Venta</th>
                    <th id="celda-principal">fecha</th>
                    <th id="celda-principal">Código</th>
                    <th id="celda-principal">Producto</th>
                    <th id="celda-principal">Precio</th>
                    <th id="celda-principal">Cantidad</th>
                    <th id="celda-principal">Descripción</th>
                    <th id="celda-principal">Categoría</th>
                    <th id="celda-principal">Acciones</th>
                </tr>';
                // Marcar la bandera como true para que no se imprima de nuevo
                $encabezadoImpreso = true;
            }

            $idcodigo = $row['idcodigo'];
            $table .= '<tr>
                <td>' . $row['idVenta'] . '</td>
                <td>' . $row['fecha_venta'] . '</td>
                <td>' . $row['idcodigo'] . '</td>
                <td>' . $row['producto'] . '</td>
                <td>' . $row['precio_unitario'] . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>' . $row['descripcion'] . '</td>
                <td>' . $row['Categoria'] . '</td>
                <td class="acciones">
                        <form action="../compartido/editarVenta.php" method="POST">
                            <input type="hidden" name="id" value="' . $row['idVenta'] . '">
                            <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                        </form>
                        <form action="../compartido/eliminarVenta.php" method="POST" onsubmit="return confirmarEliminacion();">
                            <input type="hidden" name="id" value="' . $row['idVenta'] . '">
                            <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
                        </form>
                        <a href="../Php/generar_pdf.php?id=' . $row['idVenta'] . '" target="_blank">Descargar PDF</a>
                    </td>
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
