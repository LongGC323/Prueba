<?php
$host = "192.168.160.58";//UbuntuServer1
$user = "judiva";
$pass = "judiva2002*";
$db = "inventario_db";

$conn_registros = new mysqli($host, $user, $pass, $db);
if ($conn_registros->connect_error) {
    die("Error de conexión a registros: " . $conn_registros->connect_error);
}
?>
