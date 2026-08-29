<?php
include "conexion.php";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Verificar si se ingresó el estado activo en el término de búsqueda
    $estadoActivo = false;
    if ($searchTerm == 'Activo') {
        $estadoActivo = true;
    }

    // Realizar la consulta a la base de datos con la condición de búsqueda
    $query = "SELECT * FROM usuario WHERE documentoUsuario LIKE '%$searchTerm%' OR nombresUsuario LIKE '%$searchTerm%' OR
    correo LIKE '%$searchTerm%'";
    
    // Agregar condición para filtrar usuarios inactivos solo si se busca estado activo
    if ($estadoActivo) {
        $query .= " OR (estadoUsuario = 'Activo' OR estadoUsuario IS NULL)";
    } else {
        $query .= " OR estadoUsuario LIKE '%$searchTerm%'";
    }
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error al obtener los usuarios: " . mysqli_error($conn);
    } else {
        // Construir la tabla con los resultados de la búsqueda
        $table = '';

        // Bandera para verificar si ya se ha impreso el encabezado
        $encabezadoImpreso = false;

        while ($row = mysqli_fetch_assoc($result)) {
            // Imprimir encabezado solo si no se ha impreso antes
            if (!$encabezadoImpreso) {
                $table .= '<tr>
                    <th id="celda-principal">Tipo Documento</th>
                    <th id="celda-principal">Identificación</th>
                    <th id="celda-principal">Nombre</th>
                    <th id="celda-principal">Apellido</th>
                    <th id="celda-principal">Correo</th>
                    <th id="celda-principal">Estado</th>>
                    <th id="celda-principal">Acciones</th>
                </tr>';
                // Marcar la bandera como true para que no se imprima de nuevo
                $encabezadoImpreso = true;
            }

            $idUsuario = $row['idUsuario'];
            $table .= '<tr>
                <td>' . $row['tipoDocumentoUsuario'] . '</td>
                <td>' . $row['documentoUsuario'] . '</td>
                <td>' . $row['nombresUsuario'] . '</td>
                <td>' . $row['apellidosUsuario'] . '</td>
                <td>' . $row['correo'] . '</td>
                <td>' . $row['estadoUsuario'] . '</td>
                <td class="acciones">
                    <form action="../compartido/editarUsuario.php" method="POST">
                        <input type="hidden" name="id" value="' . $idUsuario . '">
                        <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                    </form>
                    <form action="../compartido/eliminarUsuario.php" method="POST" onsubmit="return confirmarEliminacion();">
                        <input type="hidden" name="id" value="' . $idUsuario . '">
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
        return confirm("¿Estás seguro de que deseas eliminar este Usuario?");
    }
</script>
