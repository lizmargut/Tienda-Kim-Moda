<?php require_once "conexion.php";  

$query = "SELECT p.prod_id, p.prod_nombre, p.prod_color, p.prod_stock,
                 p.prod_talle, p.prod_descripcion, p.prod_precio,
                 c.cat_nombre, i.img_url
          FROM productos p
          INNER JOIN categorias c ON p.cat_id = c.cat_id
          INNER JOIN imagenes i ON p.img_id = i.img_id
          LIMIT 100";

$result = $conexion->query($query);
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
                <img src="img/<?php echo $row['img_url']; ?>" alt="Producto">

                <h3><?php echo $row['prod_nombre']; ?></h3>

                <p class="precio">$ <?php echo $row['prod_precio']; ?></p>

                <p class="stock">
                    Stock: <?php echo $row['prod_stock']; ?><br>
                    Color: <?php echo $row['prod_color']; ?><br>
                    Talle: <?php echo $row['prod_talle']; ?><br>
                    Categoría: <?php echo $row['cat_nombre']; ?>
                </p>

                <a class="btn" href="cuerpoDetalle.php?id=<?php echo $row['prod_id']; ?>">Ver más</a>
            </div>

        <?php } ?>

    </div>

</body>
</html>
