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
        echo "<div class='alert alert-danger'>Error al subir imagen</div>";
    } else {

        $imgNombre = time() . "_" . $_FILES['imagen']['name'];
        $imgTmp    = $_FILES['imagen']['tmp_name'];
        $rutaServidor = __DIR__ . "/img/" . $imgNombre;

        if (move_uploaded_file($imgTmp, $rutaServidor)) {

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
                    echo "<div class='alert alert-success text-center'>Producto agregado correctamente</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error al guardar imagen</div>";
                }

            } else {
                echo "<div class='alert alert-danger'>Error al guardar producto</div>";
            }

        } else {
            echo "<div class='alert alert-danger'>Error al mover la imagen</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Producto - Kim Moda</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/estilos4.css">

</head>

<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">

            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4 text-primary">
                        Agregar Producto
                    </h3>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="prod_nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" name="prod_color" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="prod_stock" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Talle</label>
                            <input type="text" name="prod_talle" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="prod_descripcion" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" name="prod_precio" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="cat_id" class="form-select" required>
                                <option value="">Seleccione una categoría</option>
                                <?php while ($c = $catQuery->fetch_assoc()) { ?>
                                    <option value="<?= $c['cat_id'] ?>">
                                        <?= $c['cat_nombre'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Imagen</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="guardar"
                                    class="btn btn-primary w-50">
                                Guardar
                            </button>

                            <button type="button"
                                    onclick="window.location.href='productosAdministrar.php'"
                                    class="btn btn-secondary w-50">
                                Volver
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
