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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/cuerpo.css">

<style>
/* Imagen proporcional perfecta */
.card-img-top {
    aspect-ratio: 4/5;
    object-fit: cover;
}

/* Efecto hover profesional */
.card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease;
}

/* Precio destacado */
.precio {
    font-size: 1.2rem;
    font-weight: bold;
    color: #198754;
}
</style>

</head>

<body class="bg-light">

<div class="container py-4">

    <!-- Botón agregar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Productos</h2>
        <a href="agregarProducto.php" class="btn btn-success">
            + Agregar Producto
        </a>
    </div>

    <div class="row g-4">

        <?php while ($row = $result->fetch_assoc()) { ?>

        <div class="
            col-12
            col-sm-6
            col-md-4
            col-lg-3
        ">
            <div class="card h-100 shadow-sm border-0">

                <!-- Imagen -->
                <img src="img/<?php echo $row['imagen'] ?: 'sin-imagen.png'; ?>"
                     class="card-img-top"
                     alt="Producto">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title text-truncate">
                        <?php echo $row['prod_nombre']; ?>
                    </h5>

                    <div class="precio mb-2">
                        $ <?php echo $row['prod_precio']; ?>
                    </div>

                    <p class="small text-muted mb-3">
                        Stock: <?php echo $row['prod_stock']; ?><br>
                        Color: <?php echo $row['prod_color']; ?><br>
                        Talle: <?php echo $row['prod_talle']; ?><br>
                        <?php echo $row['cat_nombre']; ?>
                    </p>

                    <!-- Botón siempre abajo -->
                    <div class="mt-auto">
                        <a class="btn btn-primary w-100"
                           href="cuerpoDetalle.php?id=<?php echo $row['prod_id']; ?>">
                           Ver más
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
