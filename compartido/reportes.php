<?php
require('fpdf.php'); // Asegúrate de usar la ruta correcta al archivo FPDF

class PDF extends FPDF
{
    function Header()
    {
        // Cabecera
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(190, 10, 'Reporte de Inventario', 0, 1, 'C');
        $this->Ln(10);

        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, 'Código', 1);
        $this->Cell(40, 10, 'Producto', 1);
        $this->Cell(30, 10, 'Precio', 1);
        $this->Cell(30, 10, 'Cantidad', 1);
        $this->Cell(40, 10, 'Descripción', 1);
        $this->Cell(20, 10, 'Categoría', 1);
        $this->Ln();
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Obtener y mostrar los datos del inventario desde la base de datos
include "../compartido/conexion.php";
$query = "SELECT * FROM productos";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error al obtener los productos: " . mysqli_error($conn);
}

$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(30, 10, $row['codigoProducto'], 1);
    $pdf->Cell(40, 10, $row['nombreProductos'], 1);
    $pdf->Cell(30, 10, $row['valorProducto'], 1);
    $pdf->Cell(30, 10, $row['stockProducto'], 1);
    $pdf->Cell(40, 10, $row['descripcionProducto'], 1);
    $pdf->Cell(20, 10, $row['nombreCategoria'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
