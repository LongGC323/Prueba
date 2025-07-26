<?php
$host = "192.168.160.147"; //UbuntuServer
$user = "judiva";
$pass = "judiva2002";
$db = "administradores";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión a catálogos: " . $conn->connect_error);
}
?>
