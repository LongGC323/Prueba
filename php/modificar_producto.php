<?php
include 'conexion_registros.php';
include 'conexion_catalogos.php'; // Conexión a la base de datos de catálogos

$id = isset($_GET['id_producto']) ? intval($_GET['id_producto']) : 0;

// Verificar si el formulario fue enviado para actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del producto que se van a actualizar
    $id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;
    $nombre_producto = $_POST['nombre_producto'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $unidad = $_POST['unidad'];
    $precio_compra = $_POST['precio_compra'];
    $precio_venta = $_POST['precio_venta'];
    $stock_actual = $_POST['stock_actual'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE producto SET 
            nombre_producto = '$nombre_producto',
            categoria = '$categoria',
            marca = '$marca',
            unidad = '$unidad',
            precio_compra = '$precio_compra',
            precio_venta = '$precio_venta',
            stock_actual = '$stock_actual' 
            WHERE id_producto = $id_producto";

    if ($conn_registros->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto: ' . $conn_registros->error]);
    }
    $conn_registros->close();
    exit; // Terminar la ejecución para evitar que se cargue el formulario
}

// Si no es un POST, mostrar el formulario y los datos actuales del producto
$sql = "SELECT * FROM producto WHERE id_producto = $id";
$result = $conn_registros->query($sql);

if ($result->num_rows === 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = $result->fetch_assoc();

// Cargar las categorías, marcas y unidades desde la base de datos de catálogos
$categorias = [];
$marcas = [];
$unidades = [];

// Obtener categorías
$res = $conn_catalogos->query("SELECT nombre_categoria FROM categoria");
while ($row = $res->fetch_assoc()) {
    $categorias[] = $row['nombre_categoria'];
}

// Obtener marcas
$res = $conn_catalogos->query("SELECT nombre_marca FROM marca");
while ($row = $res->fetch_assoc()) {
    $marcas[] = $row['nombre_marca'];
}

// Obtener unidades
$res = $conn_catalogos->query("SELECT nombre_unidad FROM unidad_medida");
while ($row = $res->fetch_assoc()) {
    $unidades[] = $row['nombre_unidad'];
}

$conn_catalogos->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modificar Producto</title>
  <link rel="stylesheet" href="../css/modificar_producto.css">
</head>
<body>
  <h2>Modificar Producto</h2>
  <form id="form-modificar" onsubmit="actualizarProducto(event)">
    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre_producto" value="<?= $producto['nombre_producto'] ?>" required><br>

    <label>Categoría:</label>
    <select name="categoria" required>
      <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria ?>" <?= $producto['categoria'] == $categoria ? 'selected' : '' ?>><?= $categoria ?></option>
      <?php endforeach; ?>
    </select><br>

    <label>Marca:</label>
    <select name="marca" required>
      <?php foreach ($marcas as $marca): ?>
        <option value="<?= $marca ?>" <?= $producto['marca'] == $marca ? 'selected' : '' ?>><?= $marca ?></option>
      <?php endforeach; ?>
    </select><br>

    <label>Unidad:</label>
    <select name="unidad" required>
      <?php foreach ($unidades as $unidad): ?>
        <option value="<?= $unidad ?>" <?= $producto['unidad'] == $unidad ? 'selected' : '' ?>><?= $unidad ?></option>
      <?php endforeach; ?>
    </select><br>

    <label>Precio Compra:</label>
    <input type="number" step="0.01" name="precio_compra" value="<?= $producto['precio_compra'] ?>" required><br>

    <label>Precio Venta:</label>
    <input type="number" step="0.01" name="precio_venta" value="<?= $producto['precio_venta'] ?>" required><br>

    <label>Stock:</label>
    <input type="number" name="stock_actual" value="<?= $producto['stock_actual'] ?>" required><br>

    <button type="submit">Actualizar</button>
    <button type="button" id="btnCancelar" onclick="window.location.href='../html/consulta_productos.html'">Cancelar</button>
  </form>

  <!-- Enlace al archivo JS -->
  <script src="../js/modificar_producto.js"></script>
</body>
</html>
