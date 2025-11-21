<?php
require_once "conexion.php";

if (!isset($_GET['id'])) {
    die("Error: ID de producto no especificado.");
}

$id = $_GET['id'];

// Consulta completa del producto
$query = "SELECT p.*, c.cat_nombre, i.img_url
          FROM productos p
          INNER JOIN categorias c ON p.cat_id = c.cat_id
          INNER JOIN imagenes i ON p.img_id = i.img_id
          WHERE p.prod_id = $id";

$result = $conexion->query($query);

if ($result->num_rows == 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle del Producto</title>
<link rel="stylesheet" href="css/detalle.css">
</head>

<body>

<div class="contenedor">
    
    <img src="img/<?php echo $producto['img_url']; ?>" alt="Producto">

    <h2><?php echo $producto['prod_nombre']; ?></h2>

    <div class="info">
        <strong>ID:</strong> <?php echo $producto['prod_id']; ?><br>
        <strong>Categoría:</strong> <?php echo $producto['cat_nombre']; ?><br>
        <strong>Color:</strong> <?php echo $producto['prod_color']; ?><br>
        <strong>Talle:</strong> <?php echo $producto['prod_talle']; ?><br>
        <strong>Stock:</strong> <?php echo $producto['prod_stock']; ?><br>
        <strong>Descripción:</strong> <?php echo $producto['prod_descripcion']; ?><br>
        <strong>Precio:</strong> $<?php echo $producto['prod_precio']; ?><br>
        <strong>Imagen:</strong> <?php echo $producto['img_url']; ?>
    </div>

    <div class="botones">
        <a class="btn editar" href="productoEditar.php?id=<?php echo $producto['prod_id']; ?>">Modificar</a>

        <a class="btn eliminar" 
           onclick="return confirm('¿Seguro que deseas eliminar este producto?')" 
           href="productoEliminar.php?id=<?php echo $producto['prod_id']; ?>">
           Eliminar
        </a>

        <a class="btn volver" href="productosAdministrar.php">Volver</a>
    </div>

</div>

</body>
</html>
