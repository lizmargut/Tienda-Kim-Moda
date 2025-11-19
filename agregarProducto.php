<?php
require_once "conexion.php";

// Traer categorías
$catQuery = $conexion->query("SELECT * FROM categorias");

// Traer imágenes
$imgQuery = $conexion->query("SELECT * FROM imagenes");

// Cuando se envía el formulario
if (isset($_POST['guardar'])) {

    $nombre = $_POST['prod_nombre'];
    $color = $_POST['prod_color'];
    $stock = $_POST['prod_stock'];
    $talle = $_POST['prod_talle'];
    $desc = $_POST['prod_descripcion'];
    $precio = $_POST['prod_precio'];
    $categoria = $_POST['cat_id'];
    $imagen = $_POST['img_id'];

    $insert = "INSERT INTO productos 
                (cat_id, prod_nombre, prod_color, prod_stock, prod_talle, 
                 prod_descripcion, prod_precio, img_id)
               VALUES 
                ($categoria, '$nombre', '$color', $stock, '$talle',
                 '$desc', $precio, $imagen)";

    if ($conexion->query($insert)) {
        echo "<script>
                alert('Producto agregado correctamente');
                window.location='cuerpo.php';
              </script>";
    } else {
        echo "<script>alert('Error al agregar producto');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Producto</title>

<style>
    body {
        background: #f2f2f2;
        font-family: Arial;
    }

    .contenedor {
        width: 60%;
        margin: 30px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    label { font-weight: bold; }

    .btnGuardar {
        margin-top: 20px;
        padding: 10px;
        width: 100%;
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .btnGuardar:hover {
        background: #1e8449;
    }
</style>

</head>
<body>

<div class="contenedor">
    <h2>Agregar Producto</h2>

    <form method="POST">

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
        <select name="img_id" required>
            <option value="">Seleccione una imagen</option>
            <?php while ($i = $imgQuery->fetch_assoc()) { ?>
                <option value="<?= $i['img_id'] ?>"><?= $i['img_url'] ?></option>
            <?php } ?>
        </select>

        <button type="submit" class="btnGuardar" name="guardar">Guardar Producto</button>

    </form>

</div>

</body>
</html>
