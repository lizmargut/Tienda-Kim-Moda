<?php
require_once "conexion.php";

if (!isset($_GET['id'])) {
    die("Error: ID no enviado.");
}

$id = $_GET['id'];

// Traer los datos actuales del producto
$query = "SELECT * FROM productos WHERE prod_id = $id";
$res = $conexion->query($query);

if ($res->num_rows == 0) {
    die("Producto no encontrado.");
}

$prod = $res->fetch_assoc();

// Traer categorías
$catQuery = $conexion->query("SELECT * FROM categorias");

// Traer imágenes
$imgQuery = $conexion->query("SELECT * FROM imagenes");

// Si se envió el formulario
if (isset($_POST['guardar'])) {

    $nombre = $_POST['prod_nombre'];
    $color = $_POST['prod_color'];
    $stock = $_POST['prod_stock'];
    $talle = $_POST['prod_talle'];
    $desc = $_POST['prod_descripcion'];
    $precio = $_POST['prod_precio'];
    $categoria = $_POST['cat_id'];
    $imagen = $_POST['img_id'];

    $update = "UPDATE productos 
               SET prod_nombre='$nombre', prod_color='$color', prod_stock=$stock,
                   prod_talle='$talle', prod_descripcion='$desc', prod_precio=$precio,
                   cat_id=$categoria, img_id=$imagen
               WHERE prod_id = $id";

    if ($conexion->query($update)) {
        echo "<script>alert('Producto actualizado correctamente'); window.location='productosAdministrar.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>

<!-- Estilos externos -->
<link rel="stylesheet" href="css/editarProducto.css">

</head>
<body>

<div class="contenedor">
    <h2>Editar Producto</h2>

    <form method="POST">

        <label>Nombre</label>
        <input type="text" name="prod_nombre" value="<?= $prod['prod_nombre'] ?>" required>

        <label>Color</label>
        <input type="text" name="prod_color" value="<?= $prod['prod_color'] ?>" required>

        <label>Stock</label>
        <input type="number" name="prod_stock" value="<?= $prod['prod_stock'] ?>" required>

        <label>Talle</label>
        <input type="text" name="prod_talle" value="<?= $prod['prod_talle'] ?>" required>

        <label>Descripción</label>
        <input type="text" name="prod_descripcion" value="<?= $prod['prod_descripcion'] ?>" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="prod_precio" value="<?= $prod['prod_precio'] ?>" required>

        <label>Categoría</label>
        <select name="cat_id" required>
            <?php while ($c = $catQuery->fetch_assoc()) { ?>
                <option value="<?= $c['cat_id'] ?>" 
                    <?= ($c['cat_id'] == $prod['cat_id']) ? 'selected' : '' ?>>
                    <?= $c['cat_nombre'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Imagen</label>
        <select name="img_id" required>
            <?php while ($i = $imgQuery->fetch_assoc()) { ?>
                <option value="<?= $i['img_id'] ?>"
                    <?= ($i['img_id'] == $prod['img_id']) ? 'selected' : '' ?>>
                    <?= $i['img_url'] ?>
                </option>
            <?php } ?>
        </select>

        <!-- BOTÓN GUARDAR -->
        <button type="submit" class="btnGuardar" name="guardar">Guardar Cambios</button>

    </form>

</div>

</body>
</html>
