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
<link rel="stylesheet" href="css/estilos4.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
