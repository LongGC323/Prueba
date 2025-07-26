<?php
include 'conexion_catalogos.php'; // Conexión a la base de datos de catálogos

$tipo = $_GET['tipo'];

switch ($tipo) {
    case 'categoria':
        $sql = "SELECT nombre_categoria AS nombre FROM categoria";
        break;
    case 'marca':
        $sql = "SELECT nombre_marca AS nombre FROM marca";
        break;
    case 'unidad':
        $sql = "SELECT nombre_unidad AS nombre FROM unidad_medida";
        break;
    default:
        echo json_encode([]);
        exit;
}

$result = $conn_catalogos->query($sql);
$opciones = [];

while ($row = $result->fetch_assoc()) {
    $opciones[] = $row['nombre'];  // Solo el valor de texto, no objeto
}

echo json_encode($opciones);

$conn_catalogos->close();
?>
