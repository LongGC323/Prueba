<?php
require('fpdf/fpdf.php');
date_default_timezone_set('America/Mexico_City');

class PDF extends FPDF {
    function Header() {
        // Logo en la esquina superior izquierda
        $this->Image('../imagenes/logo.png', 8, 6, 24); // Cambia el nombre y tamaño según tu imagen
    }

    // Agrega función Rotate al FPDF
    protected $angle = 0;
    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm',
                $c, $s, -$s, $c, $cx, $cy));
        }
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}

function t($texto) {
    return utf8_decode($texto);
}

$conn = new mysqli("192.168.160.58", "judiva", "judiva2002*", "inventario_db");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM producto"; // Consulta ajustada según la estructura de la tabla
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("No hay productos registrados.");
}

// Crear el objeto PDF en orientación horizontal ('L')
$pdf = new PDF('L'); // Aquí se establece la orientación horizontal
$pdf->AddPage(); // Agregar página al PDF

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, t('Lista de Productos Sistema JUDIVA.'), 0, 1, 'C');
$pdf->Ln(10);

// Tabla centrada
$total_width = 260;
$start_x = (297 - $total_width) / 2; // Aseguramos que la tabla esté centrada en una página horizontal

$pdf->SetX($start_x);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, t('ID'), 1);
$pdf->Cell(70, 10, t('Nombre'), 1);
$pdf->Cell(30, 10, t('Categoría'), 1);
$pdf->Cell(30, 10, t('Marca'), 1);
$pdf->Cell(30, 10, t('Unidad'), 1);
$pdf->Cell(32, 10, t('Precio Compra'), 1);
$pdf->Cell(30, 10, t('Precio Venta'), 1);
$pdf->Cell(30, 10, t('Stock'), 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->SetX($start_x);
    $pdf->Cell(20, 10, t($row['id_producto']), 1);
    $pdf->Cell(70, 10, t($row['nombre_producto']), 1);
    $pdf->Cell(30, 10, t($row['categoria']), 1);
    $pdf->Cell(30, 10, t($row['marca']), 1);
    $pdf->Cell(30, 10, t($row['unidad']), 1);
    $pdf->Cell(32, 10, t('$' . number_format($row['precio_compra'], 2)), 1);
    $pdf->Cell(30, 10, t('$' . number_format($row['precio_venta'], 2)), 1);
    $pdf->Cell(30, 10, t($row['stock_actual']), 1);
    $pdf->Ln();
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, t('Reporte generado el ') . date('d/m/Y H:i'), 0, 0, 'R');

$pdf->Output();
?>
