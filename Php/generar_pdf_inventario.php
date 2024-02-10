<?php
require('../Php/fpdf/fpdf.php'); 

class PDF extends FPDF
{
    // Encabezado de página
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Detalle de Venta', 0, 1, 'C');
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'FERRETERIA MEISSEN - Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

include "../compartido/conexion.php";

$idventa = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID de venta no proporcionado.');

$sql = "SELECT * FROM productos WHERE idProducto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $idventa);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(0, 10, 'ID Producto: ' . $row['codigoProducto'], 0, 1);
    $pdf->Cell(0, 10, 'Producto: ' . $row['nombreProductos'], 0, 1);
    $pdf->Cell(0, 10, 'Precio Unitario: $' . $row['valorProducto'], 0, 1);
    $pdf->Cell(0, 10, 'Cantidad: ' . $row['stockProducto'], 0, 1);
    $pdf->Cell(0, 10, 'Descripción: ' . $row['descripcionProducto'], 0, 1);
    $pdf->Cell(0, 10, 'Categoría: ' . $row['nombreCategoria'], 0, 1);

    $pdf->Output('D', 'DetalleVenta_' . $idventa . '.pdf');
} else {
    echo "No se encontró la venta.";
}

$stmt->close();
$conn->close();
?>
