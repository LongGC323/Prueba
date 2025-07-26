<?php
include 'conexion_registros.php'; // Conexión a la base de datos de productos

// Recibir directamente los valores de texto enviados desde el formulario
$nombre_producto = $_POST['nombre_producto'];
$categoria = $_POST['categoria'];  // Ya es el texto (ej. 'Bebidas')
$marca = $_POST['marca'];          // Ya es el texto (ej. 'Coca-Cola')
$unidad = $_POST['unidad'];        // Ya es el texto (ej. 'Litros')
$stock_actual = $_POST['stock_actual'];
$precio_compra = $_POST['precio_compra'];
$precio_venta = $_POST['precio_venta'];

// Insertar directamente los valores de texto
$sql = "INSERT INTO producto (nombre_producto, categoria, marca, unidad, stock_actual, precio_compra, precio_venta) 
        VALUES ('$nombre_producto', '$categoria', '$marca', '$unidad', '$stock_actual', '$precio_compra', '$precio_venta')";

if ($conn_registros->query($sql) === TRUE) {
    echo "Producto registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn_registros->error;
}

$conn_registros->close();
?>
