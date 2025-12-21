<?php
require_once "conexion.php";

// Traer categorías
$catQuery = $conexion->query("SELECT * FROM categorias");

if (isset($_POST['guardar'])) {

    $nombre    = $_POST['prod_nombre'];
    $color     = $_POST['prod_color'];
    $stock     = $_POST['prod_stock'];
    $talle     = $_POST['prod_talle'];
    $desc      = $_POST['prod_descripcion'];
    $precio    = $_POST['prod_precio'];
    $categoria = $_POST['cat_id'];

    // ===== SUBIR IMAGEN =====
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] != 0) {
        die("❌ Error al subir imagen");
    }

    $imgNombre = time() . "_" . $_FILES['imagen']['name'];
    $imgTmp    = $_FILES['imagen']['tmp_name'];
    $rutaServidor = __DIR__ . "/img/" . $imgNombre;

    if (!move_uploaded_file($imgTmp, $rutaServidor)) {
        die("❌ Error al mover la imagen");
    }

    // ===== INSERT PRODUCTO =====
    $sqlProducto = "INSERT INTO productos
    (cat_id, prod_nombre, prod_color, prod_stock, prod_talle,
     prod_descripcion, prod_precio)
    VALUES
    ($categoria, '$nombre', '$color', $stock, '$talle',
     '$desc', $precio)";

    if ($conexion->query($sqlProducto)) {

        $prod_id = $conexion->insert_id;

        // ===== INSERT IMAGEN =====
        $sqlImg = "INSERT INTO imagenes (img_ruta, prod_id)
                   VALUES ('$imgNombre', $prod_id)";

        if ($conexion->query($sqlImg)) {
            echo "<script>alert('✅ Producto agregado correctamente');</script>";
        } else {
            echo "❌ Error al guardar imagen: " . $conexion->error;
        }

    } else {
        echo "❌ Error al guardar producto: " . $conexion->error;
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Producto</title>
<link rel="stylesheet" href="css/estilos4.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="contenedor">
    <h2>Agregar Producto</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Nombre</label>
        <input type="text" name="prod_nombre" required>

        <label>Color</label>
        <input type="text" name="prod_color" required>

        <label>Stock</label>
        <input type="number" name="prod_stock" required>

        <label>Talle</label>
        <input type="text" name="prod_talle" required>

        <label>Descripción</label>
        <input type="text" name="prod_descripcion" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="prod_precio" required>

        <label>Categoría</label>
        <select name="cat_id" required>
            <option value="">Seleccione una categoría</option>
            <?php while ($c = $catQuery->fetch_assoc()) { ?>
                <option value="<?= $c['cat_id'] ?>"><?= $c['cat_nombre'] ?></option>
            <?php } ?>
        </select>

        <label>Imagen</label>
    <input type="file" name="imagen" accept="image/*" required>
    <button type="submit" name="guardar">Guardar Producto</button>

    </form>

</div>

</body>
</html>
