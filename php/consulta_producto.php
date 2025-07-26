<?php
include 'conexion_registros.php';

$busqueda = isset($_GET['busqueda']) ? $conn_registros->real_escape_string($_GET['busqueda']) : '';

$sql = "SELECT id_producto, nombre_producto, categoria, marca, unidad, precio_compra, precio_venta, stock_actual FROM producto";

if (!empty($busqueda)) {
    $sql .= " WHERE nombre_producto LIKE '%$busqueda%' OR categoria LIKE '%$busqueda%' OR marca LIKE '%$busqueda%' OR unidad LIKE '%$busqueda%'";
}

$result = $conn_registros->query($sql);

$productos = [];
while ($row = $result->fetch_assoc()) {
    $producto = [
        'id_producto' => $row['id_producto'],
        'nombre_producto' => $row['nombre_producto'],
        'categoria' => $row['categoria'],
        'marca' => $row['marca'],
        'unidad' => $row['unidad'],
        'precio_compra' => $row['precio_compra'],
        'precio_venta' => $row['precio_venta'],
        'stock' => $row['stock_actual'],
    ];
    $productos[] = $producto;
}

$conn_registros->close();

echo json_encode($productos);
?>
