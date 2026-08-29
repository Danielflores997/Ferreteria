<?php
include "conexion.php";
// Consultar productos con stock menor a 10
$query_stock_escaso = "SELECT * FROM productos WHERE stockProducto < 10";
$result_stock_escaso = mysqli_query($conn, $query_stock_escaso);
$productos_escasos = [];
while ($row_stock_escaso = mysqli_fetch_assoc($result_stock_escaso)) {
    $productos_escasos[] = $row_stock_escaso;
}
// Devolver los resultados como JSON
echo json_encode($productos_escasos);
?>
