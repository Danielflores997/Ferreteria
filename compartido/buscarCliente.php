<?php
include "conexion.php";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Realizar la consulta a la base de datos con la condición de búsqueda
    $query = "SELECT * FROM cliente WHERE documentoCliente LIKE '%$searchTerm%' OR nombresCliente LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al obtener los clientes: " . mysqli_error($conn);
    } else {
        // Construir la tabla con los resultados de la búsqueda
        $table = '';

        while ($row = mysqli_fetch_assoc($result)) {
            $idCliente = $row['idCliente'];
            $table .= '<tr>
                <td>' . $row['tipoDocumentoCliente'] . '</td>
                <td>' . $row['documentoCliente'] . '</td>
                <td>' . $row['nombresCliente'] . '</td>
                <td>' . $row['apellidosCliente'] . '</td>
                <td>' . $row['telefonoCliente'] . '</td>
                <td>' . $row['direccionCliente'] . '</td>
                <td>' . $row['estadoCliente'] . '</td>
                <td class="acciones">
                    <form action="../compartido/editarCliente.php" method="POST">
                        <input type="hidden" name="id" value="' . $idCliente . '">
                        <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                    </form>
                    <form action="../compartido/eliminarCliente.php" method="POST" onsubmit="return confirmarEliminacion();">
                        <input type="hidden" name="id" value="' . $idCliente . '">
                        <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>';
        }
        echo $table;
    }
}
?>

<script>
    function confirmarEliminacion() {
        return confirm("¿Estás seguro de que deseas eliminar este cliente?");
    }
</script>