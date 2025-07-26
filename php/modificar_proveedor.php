<?php
include 'conexion_registros.php';

$mensaje_exito = '';
$error = '';
$proveedor = null;

// Si llega por POST, procesa la modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_proveedor'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    if (!empty($nombre) && !empty($telefono) && !empty($email)) {
        $sql = "UPDATE proveedor SET nombre=?, telefono=?, email=? WHERE id_proveedor=?";
        $stmt = $conn_registros->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $telefono, $email, $id);

        if ($stmt->execute()) {
            $mensaje_exito = "Proveedor modificado correctamente.";
        } else {
            $error = "Error al modificar el proveedor.";
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}

// Si llega por GET, obtiene los datos del proveedor
$id = isset($_GET['id_proveedor']) ? $_GET['id_proveedor'] : ($_POST['id_proveedor'] ?? '');

if ($id) {
    $sql = "SELECT id_proveedor, nombre, telefono, email FROM proveedor WHERE id_proveedor = ?";
    $stmt = $conn_registros->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proveedor = $result->fetch_assoc();
}

$conn_registros->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Proveedor</title>
    <link rel="stylesheet" href="../css/modificar_proveedor.css">
</head>
<body>
    <h2>Modificar Proveedor</h2>

    <?php if ($mensaje_exito): ?>
        <div class="mensaje-exito"><?= $mensaje_exito ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="mensaje-error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($proveedor): ?>
    <form method="POST">
        <input type="hidden" name="id_proveedor" value="<?= $proveedor['id_proveedor'] ?>">
        <input type="text" name="nombre" value="<?= $proveedor['nombre'] ?>" required>
        <input type="text" name="telefono" value="<?= $proveedor['telefono'] ?>" required>
        <input type="email" name="email" value="<?= $proveedor['email'] ?>" required>
        <button type="submit" id="btnGuardar">Guardar Cambios</button>
    </form>
    <?php else: ?>
        <p>Proveedor no encontrado.</p>
    <?php endif; ?>

    <button id="btnVolver" onclick="window.location.href='../html/consulta_proveedor.html'">Volver</button>
    <script src="../js/modificar_proveedor.js"></script>
</body>
</html>