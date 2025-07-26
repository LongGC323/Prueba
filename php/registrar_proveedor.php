<?php
include 'conexion_registros.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $sql = "INSERT INTO proveedor (nombre, telefono, email) VALUES (?, ?, ?)";
    $stmt = $conn_registros->prepare($sql);
    $stmt->bind_param("sss", $nombre, $telefono, $email);

    if ($stmt->execute()) {
        echo "Proveedor registrado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn_registros->close();
}
?>
