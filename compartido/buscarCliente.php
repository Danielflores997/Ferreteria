<?php
include "conexion.php";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Verificar si se ingresó el estado activo en el término de búsqueda
    $estadoActivo = false;
    if ($searchTerm == 'Activo' || $searchTerm == 'Inactivo') {
        $estadoActivo = true;
    }

    // Realizar la consulta a la base de datos con la condición de búsqueda
    $query = "SELECT * FROM cliente WHERE documentoCliente LIKE '%$searchTerm%' OR nombresCliente LIKE '%$searchTerm%' OR
    telefonoCliente LIKE '%$searchTerm%'";
    
    // Agregar condición para filtrar clientes activos o inactivos solo si se busca estado activo o inactivo
    if ($estadoActivo) {
        $query .= " OR estadoCliente LIKE '%$searchTerm%'";
    }
    
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo '<div class ="mensajes-alertas">¡Error al obtener los clientes.
        <div class ="mensaje-boton"><a href="../compartido/buscarCliente.php">Aceptar</a></div>'. mysqli_error($conn);
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
                    <th id="celda-principal">Teléfono</th>
                    <th id="celda-principal">Dirección</th>
                    <th id="celda-principal">Estado</th>
                    <th id="celda-principal">Acciones</th>
                </tr>';
                // Marcar la bandera como true para que no se imprima de nuevo
                $encabezadoImpreso = true;
            }

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
