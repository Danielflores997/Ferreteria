<?php
require('../Php/fpdf/fpdf.php'); // Asegúrate de ajustar la ruta al directorio donde guardaste FPDF

class PDF extends FPDF
{
    // Encabezado de página
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logo.png',10,6,30); // Asume que tienes un logo en la misma carpeta, ajusta la ruta según sea necesario
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Detalle de Venta', 0, 1, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial itálica 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'FERRETERIA MEISSEN - Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

include "../compartido/conexion.php"; // Asegúrate de que este es el camino correcto al archivo de conexión

$idventa = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID de venta no proporcionado.');

$sql = "SELECT * FROM ventas WHERE idVenta = ?";
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

    // Ahora incluiremos más campos en el PDF
    $pdf->Cell(0, 10, 'ID Venta: ' . $row['idVenta'], 0, 1);
    $pdf->Cell(0, 10, 'Fecha de Venta: ' . $row['fecha_venta'], 0, 1);
    $pdf->Cell(0, 10, 'ID Producto: ' . $row['idcodigo'], 0, 1);
    $pdf->Cell(0, 10, 'Producto: ' . $row['producto'], 0, 1);
    $pdf->Cell(0, 10, 'Precio Unitario: $' . $row['precio_unitario'], 0, 1);
    $pdf->Cell(0, 10, 'Cantidad: ' . $row['cantidad'], 0, 1);
    $pdf->Cell(0, 10, 'Descripcion: ' . $row['descripcion'], 0, 1);
    $pdf->Cell(0, 10, 'Categoria: ' . $row['Categoria'], 0, 1);
    // Aquí puedes seguir agregando todos los campos necesarios

    // Imaginemos que quieres incluir una imagen del producto si está disponible
  

    // Supongamos que quieres añadir un total calculado
    $total = $row['precio_unitario'] * $row['cantidad'];
    $pdf->Cell(0, 10, 'Total: $' . $total, 0, 1);

    $pdf->Output('D', 'DetalleVenta_' . $idventa . '.pdf');
} else {
    echo "No se encontró la venta.";
}

$stmt->close();
$conn->close();
?>
