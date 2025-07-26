<?php
$host = "192.168.160.147";//UbuntuServer
$user = "judiva";
$pass = "judiva2002";
$db = "catalogos_db";

$conn_catalogos = new mysqli($host, $user, $pass, $db);
if ($conn_catalogos->connect_error) {
    die("Error de conexión a catálogos: " . $conn_catalogos->connect_error);
}
?>
