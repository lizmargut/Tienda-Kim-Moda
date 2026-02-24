<?php
require_once "conexion.php";

if (!isset($_GET['id'])) {
    die("Error: ID no enviado.");
}

$prod_id = $_GET['id'];

/* ===============================
   TRAER PRODUCTO
================================ */
$query = "SELECT * FROM productos WHERE prod_id = $prod_id";
$res = $conexion->query($query);

if (!$res || $res->num_rows == 0) {
    die("Producto no encontrado.");
}

$prod = $res->fetch_assoc();

/* ===============================
   TRAER CATEGORÍAS
================================ */
$catQuery = $conexion->query("SELECT * FROM categorias");

/* ===============================
   CONTAR IMÁGENES ACTUALES
================================ */
$resCount = $conexion->query("SELECT COUNT(*) AS total FROM imagenes WHERE prod_id = $prod_id");
$totalImg = $resCount->fetch_assoc()['total'];

/* ===============================
   GUARDAR IMÁGENES (MÁX 3)
================================ */
if (isset($_POST['guardar']) && !empty($_FILES['imagenes']['name'][0])) {

    $cantidad = count($_FILES['imagenes']['name']);

    if ($cantidad + $totalImg > 3) {
        die("Solo se permiten hasta 3 imágenes por producto");
    }

    for ($i = 0; $i < $cantidad; $i++) {

        $tmp = $_FILES['imagenes']['tmp_name'][$i];
        $nombreOriginal = $_FILES['imagenes']['name'][$i];
        $tipo = $_FILES['imagenes']['type'][$i];

        if ($tmp == "") continue;

        $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($tipo, $permitidos)) continue;

        $nombreFinal = time() . "_" . basename($nombreOriginal);
        $ruta = "img/" . $nombreFinal;

        if (move_uploaded_file($tmp, $ruta)) {
            $sqlImg = "INSERT INTO imagenes (img_ruta, prod_id)
                       VALUES ('$nombreFinal', $prod_id)";
            $conexion->query($sqlImg);
        }
    }
}

/* ===============================
   ACTUALIZAR PRODUCTO
================================ */
if (isset($_POST['guardar'])) {

    $nombre = $_POST['prod_nombre'];
    $color = $_POST['prod_color'];
    $stock = $_POST['prod_stock'];
    $talle = $_POST['prod_talle'];
    $desc = $_POST['prod_descripcion'];
    $precio = $_POST['prod_precio'];
    $categoria = $_POST['cat_id'];

    $update = "UPDATE productos 
               SET prod_nombre='$nombre',
                   prod_color='$color',
                   prod_stock=$stock,
                   prod_talle='$talle',
                   prod_descripcion='$desc',
                   prod_precio=$precio,
                   cat_id=$categoria
               WHERE prod_id = $prod_id";

    if ($conexion->query($update)) {
        echo "<script>alert('Producto actualizado correctamente'); window.location='productosAdministrar.php';</script>";
        exit;
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

    <form method="POST" enctype="multipart/form-data">

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
        <label>Imágenes del producto (máx 3)</label>
        <input type="file" name="imagenes[]" multiple accept="image/*">

        </select>

        <!-- BOTÓN GUARDAR -->
        <button type="submit" name="guardar"
<<<<<<< HEAD
                                    class="btn btn-primary w-50">
                                Guardar cambios
        </button>
=======
                class="btn btn-primary w-50">Guardar cambios</button>
>>>>>>> 4a48a63eb8622b9aed13be9728cd4b85e5de2640
        

        <button type="button"
                                    onclick="window.location.href='productosAdministrar.php'"
                                    class="btn btn-secondary w-50">
                                Volver
        </button>
    </form>

</div>

</body>
</html>
