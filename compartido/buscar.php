<?php
include "conexion.php";

// Obtener el término de búsqueda enviado por AJAX
$searchTerm = $_POST['searchTerm'];

// Realizar la consulta a la base de datos con la condición de búsqueda
$query = "SELECT * FROM cliente WHERE nombresCliente LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error al obtener los clientes: " . mysqli_error($conn);
} else {
    // Construir la tabla con los resultados de la búsqueda
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
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
}
?>

