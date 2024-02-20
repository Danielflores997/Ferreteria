<?php
// Incluir la conexión a la base de datos
include "../compartido/conexion.php";

mysqli_set_charset($conn, "utf8");

// Definir el nombre del archivo de salida
$nombreArchivo = "detalle_ventas_" . date('Ymd') . ".csv";

// Configurar para que el navegador entienda que se trata de una descarga
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');

// Abrir el archivo PHP para la salida
$output = fopen('php://output', 'w');

// Opcional: Si deseas incluir BOM para UTF-8 para asegurar la compatibilidad con Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Establecer el delimitador de campo
$delimitador = ';';

// Escribir los títulos de las columnas
$header = array('ID', 'Producto', 'Precio Unitario', 'Cantidad', 'Descripcion', 'Categoria');
fputcsv($output, $header, $delimitador);

// Ejecutar la consulta
$query = "SELECT * FROM ventas"; // Asegúrate de ajustar esto para que coincida con tu esquema de base de datos real
$result = mysqli_query($conn, $query);

// Iterar sobre los resultados de la consulta y escribir en el archivo CSV
while ($row = mysqli_fetch_assoc($result)) {
    $fila = array(
        $row['idcodigo'], // Asegúrate de que los nombres de las columnas coincidan con tu base de datos
        $row['producto'],
        $row['precio_unitario'], // Aquí se asume que el precio unitario ya está en el formato correcto
        $row['cantidad'],
        $row['descripcion'],
        $row['Categoria'],
    );
    fputcsv($output, $fila, $delimitador);
}

// Cerrar el archivo de salida
fclose($output);
?>
