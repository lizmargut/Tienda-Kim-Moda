<?php
require_once "conexion.php";

$sql = "SELECT p.*, c.cat_nombre,
               (SELECT img_ruta
                FROM imagenes
                WHERE prod_id = p.prod_id
                LIMIT 1) AS imagen
        FROM productos p
        INNER JOIN categorias c ON p.cat_id = c.cat_id";

$result = $conexion->query($sql);

if (!$result) {
    die("Error en consulta productos: " . $conexion->error);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="css/cuerpo.css"> 
</head>

<body>

<!-- BOTÓN AGREGAR PRODUCTO -->
<a href="agregarProducto.php" class="btnAgregar">+ Agregar Producto</a>

<div class="contenedor">

<?php while ($row = $result->fetch_assoc()) { ?>
    <div class="card">

    <!-- CONTENEDOR IMAGEN -->
    <div class="img-producto">
        <img src="img/<?php echo $row['imagen'] ?: 'sin-imagen.png'; ?>" alt="Producto">
    </div>

    <!-- CONTENIDO -->
    <div class="card-body">
        <h3><?php echo $row['prod_nombre']; ?></h3>

        <p class="precio">$ <?php echo $row['prod_precio']; ?></p>

        <p class="stock">
            Stock: <?php echo $row['prod_stock']; ?><br>
            Color: <?php echo $row['prod_color']; ?><br>
            Talle: <?php echo $row['prod_talle']; ?><br>
            Categoría: <?php echo $row['cat_nombre']; ?>
        </p>

        <a class="btn" href="cuerpoDetalle.php?id=<?php echo $row['prod_id']; ?>">
            Ver más
        </a>
    </div>

</div>

<?php } ?>

</div>

</body>
</html>

