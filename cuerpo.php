<?php
require_once "conexion.php";

// Consulta para mostrar solo 3 productos por ahora
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

    <style>
        body {
            background: #f2f2f2;
            font-family: Arial, Helvetica, sans-serif;
        }

        .btnAgregar {
            display: inline-block;
            background: #f3b3ddff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0 0 5%;
        }

        .btnAgregar:hover {
            background: #d62b9dff;
        }

        .contenedor {
            width: 90%;
            margin: 30px auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .card {
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card h3 {
            margin: 10px 0 5px;
            font-size: 20px;
            font-weight: bold;
        }

        .precio {
            color: #3a7bd5;
            font-size: 18px;
            font-weight: bold;
        }

        .stock {
            font-size: 14px;
            color: #444;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #3a7bd5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .btn:hover {
            background: #2a5fa1;
        }
    </style>
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
