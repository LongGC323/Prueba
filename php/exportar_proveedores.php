<?php
require('fpdf/fpdf.php');
date_default_timezone_set('America/Mexico_City');

class PDF extends FPDF {
    function Header() {
        // Logo en la esquina superior izquierda
        $this->Image('../imagenes/logo.png', 10, 8, 30); // Cambia el nombre y tamaño según tu imagen
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

$sql = "SELECT * FROM proveedor";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("No hay proveedores registrados.");
}

// Crear el objeto PDF correctamente
$pdf = new PDF(); // Aquí se crea el objeto de la clase PDF
$pdf->AddPage(); // Agregar página al PDF

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, t('Lista de Proveedores Sistema JUDIVA.'), 0, 1, 'C');
$pdf->Ln(10);

// Tabla centrada
$total_width = 130;
$start_x = (210 - $total_width) / 2;

$pdf->SetX($start_x);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, t('ID'), 1);
$pdf->Cell(60, 10, t('Nombre'), 1);
$pdf->Cell(50, 10, t('Teléfono'), 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->SetX($start_x);
    $pdf->Cell(20, 10, t($row['id_proveedor']), 1);
    $pdf->Cell(60, 10, t($row['nombre']), 1);
    $pdf->Cell(50, 10, t($row['telefono']), 1);
    $pdf->Ln();
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, t('Reporte generado el ') . date('d/m/Y H:i'), 0, 0, 'R');

$pdf->Output();
?>
