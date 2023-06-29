<?php
include "conexion.php";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Realizar la consulta a la base de datos con la condición de búsqueda
    $query = "SELECT * FROM usuario WHERE documentopUsuario LIKE '%$searchTerm%' OR nombresUsuario LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al obtener los usuarios: " . mysqli_error($conn);
    } else {
        // Construir la tabla con los resultados de la búsqueda
        $table = '';

        while ($row = mysqli_fetch_assoc($result)) {
            $table .= '<tr>
                <td>' . $row['tipoDocumentoUsuario'] . '</td>
                <td>' . $row['documentopUsuario'] . '</td>
                <td>' . $row['nombresUsuario'] . '</td>
                <td>' . $row['apellidosUsuario'] . '</td>
                <td>' . $row['correo'] . '</td>
                <td>' . $row['estadoUsuario'] . '</td>
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