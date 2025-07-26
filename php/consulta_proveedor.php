<?php
header('Content-Type: application/json');
include 'conexion_registros.php';

$busqueda = isset($_GET['busqueda']) ? $conn_registros->real_escape_string($_GET['busqueda']) : '';

$sql = "SELECT id_proveedor, nombre, telefono, email FROM proveedor"; // Agregamos 'id' para poder modificar
if (!empty($busqueda)) {
    $sql .= " WHERE nombre LIKE '%$busqueda%' OR email LIKE '%$busqueda%'";
}

$result = $conn_registros->query($sql);

$proveedores = [];

while ($row = $result->fetch_assoc()) {
    $proveedores[] = $row;
}

echo json_encode($proveedores);

$conn_registros->close();
?>
