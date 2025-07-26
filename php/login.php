<?php
header('Content-Type: application/json');
include 'conexion_administradores.php';

$user = $_POST['user'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM usuario WHERE user = ? AND password = ?");
$stmt->bind_param("ss", $user, $password);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode(["success" => $result->num_rows === 1]);
$conn->close();
?>
