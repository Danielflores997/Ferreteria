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
            $table .= '<tr>
                <td>' . $row['tipoDocumentoCliente'] . '</td>
                <td>' . $row['documentoCliente'] . '</td>
                <td>' . $row['nombresCliente'] . '</td>
                <td>' . $row['apellidosCliente'] . '</td>
                <td>' . $row['telefonoCliente'] . '</td>
                <td>' . $row['direccionCliente'] . '</td>
                <td>' . $row['estadoCliente'] . '</td>
                <td class="acciones">
                    <button><i class="fas fa-edit"></i></button>
                    <button><i class="fas fa-trash"></i></button>
                </td>
            </tr>';
        }

        echo $table;
    }
}
?>





