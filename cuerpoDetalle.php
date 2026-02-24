<?php
require_once "conexion.php";

if (!isset($_GET['id'])) {
    die("ID de producto no especificado");
}

$id = (int) $_GET['id'];

/* ===============================
   TRAER PRODUCTO
================================ */
$sqlProd = "SELECT p.*, c.cat_nombre
            FROM productos p
            INNER JOIN categorias c ON p.cat_id = c.cat_id
            WHERE p.prod_id = $id";

$resProd = $conexion->query($sqlProd);

if (!$resProd || $resProd->num_rows === 0) {
    die("Producto no encontrado");
}

$producto = $resProd->fetch_assoc();

/* ===============================
   TRAER IMÁGENES (MÁX 3)
================================ */
// $sqlImg = "SELECT img_ruta
//            FROM imagenes
//            WHERE prod_id = $id
//            LIMIT 3";
$sqlImg = "SELECT img_id, img_ruta
           FROM imagenes
           WHERE prod_id = $id
           LIMIT 3";
$resImg = $conexion->query($sqlImg);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle del Producto</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS propio -->
<link rel="stylesheet" href="css/detalle.css">
</head>

<body>

<div class="contenedor container mt-4">

<!-- ===============================
     CARRUSEL
================================ -->
<div id="carouselProducto" class="carousel slide mb-4" data-bs-ride="carousel">

    <div class="carousel-inner">

        <?php
        if ($resImg->num_rows > 0) {
            $active = "active";
        while ($img = $resImg->fetch_assoc()) {
?>
    <div class="carousel-item <?= $active ?>">
        <img src="img/<?= $img['img_ruta'] ?>" class="d-block w-100" alt="Imagen producto">

        <div class="text-center mt-2">
            <a class="btn btn-sm btn-danger"
               onclick="return confirm('¿Eliminar esta imagen?')"
               href="imagenEliminar.php?id=<?= $img['img_id'] ?>&prod=<?= $producto['prod_id'] ?>">
               Eliminar imagen
            </a>
        </div>
    </div>
<?php
    $active = "";
}
        } else {
        ?>
            <div class="carousel-item active">
                <img src="img/sin-imagen.png" class="d-block w-100" alt="Sin imagen">
            </div>
        <?php } ?>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- ===============================
     INFO DEL PRODUCTO
================================ -->
<h2><?= $producto['prod_nombre'] ?></h2>

<div class="info">
    <strong>ID:</strong> <?= $producto['prod_id'] ?><br>
    <strong>Categoría:</strong> <?= $producto['cat_nombre'] ?><br>
    <strong>Color:</strong> <?= $producto['prod_color'] ?><br>
    <strong>Talle:</strong> <?= $producto['prod_talle'] ?><br>
    <strong>Stock:</strong> <?= $producto['prod_stock'] ?><br>
    <strong>Descripción:</strong> <?= $producto['prod_descripcion'] ?><br>
    <strong>Precio:</strong> $<?= $producto['prod_precio'] ?><br>
</div>

<!-- ===============================
     BOTONES
================================ -->
<div class="mt-3">
    <a class="btn btn-warning" href="productoEditar.php?id=<?= $producto['prod_id'] ?>">Modificar</a>
    <a class="btn btn-danger"
       onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
       href="productoEliminar.php?id=<?= $producto['prod_id'] ?>">Eliminar</a>
    <a class="btn btn-secondary" href="productosAdministrar.php">Volver</a>
    
</div>
<div class="carousel-item <?= $active ?>">
    <img src="img/<?= $img['img_ruta'] ?>" class="d-block w-100">

    <div class="text-center mt-2">
        <a class="btn btn-sm btn-danger"
           onclick="return confirm('¿Eliminar esta imagen?')"
           href="imagenEliminar.php?id=<?= $img['img_id'] ?>&prod=<?= $producto['prod_id'] ?>">
           Eliminar imagen
        </a>
    </div>
</div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
