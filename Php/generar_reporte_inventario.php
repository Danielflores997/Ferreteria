<?php
require('../Php/fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../imagenes/logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Informe de Inventario', 0, 1, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function TablaVentas($header, $ventas)
    {
        $w = array(15, 35, 20, 20, 60, 30, 25);
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B', 12);
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 7, $col, 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('', '', 10);
        foreach ($ventas as $row) {
            $this->Cell($w[0], 6, $row['codigoProducto'] ?? '', 'LR', 0, 'L');
            $this->Cell($w[1], 6, $row['nombreProductos'] ?? '', 'LR', 0, 'L');
            $this->Cell($w[2], 6, number_format($row['valorProducto'] ?? 0, 2, '.', ','), 'LR', 0, 'R');
            $this->Cell($w[3], 6, $row['stockProducto'] ?? '', 'LR', 0, 'R');
            $this->Cell($w[4], 6, $row['descripcionProducto'] ?? '', 'LR', 0, 'L');
            $this->Cell($w[5], 6, $row['nombreCategoria'] ?? '', 'LR', 0, 'L');

            $this->Ln();
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

include "../compartido/conexion.php";
mysqli_set_charset($conn, "utf8");

$pdf = new PDF();
$header = array('ID', 'Producto', 'Precio', 'Cantidad', 'Descripcion', 'Categoria');
$pdf->AliasNbPages();
$pdf->AddPage('P', 'letter'); // Cambiar 'A4' por 'letter' para utilizar tamaño de hoja carta
$pdf->SetFont('Arial', '', 10);
$pdf->SetAutoPageBreak(true, 10);

$query = "SELECT * FROM productos";
$result = mysqli_query($conn, $query);
$ventas = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ventas[] = $row;
}

$pdf->TablaVentas($header, $ventas);
$pdf->Output();
?>
