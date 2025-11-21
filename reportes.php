<?php
include("conexion.php");

// =======================================================
// CONSULTAS PARA LOS REPORTES
// =======================================================

// 1. VENTAS (PEDIDOS)
$ventasQuery = mysqli_query($conexion, "
    SELECT p.pedido_id, p.pedido_fecha, p.pedido_estado, 
           c.cli_nombre, c.cli_apellido, 
           e.emp_nombre, e.emp_apellido 
    FROM pedidos p
    INNER JOIN clientes c ON p.cli_id = c.cli_id
    INNER JOIN empleados e ON p.emp_id = e.emp_id
    ORDER BY p.pedido_fecha DESC
");

// 2. PRODUCTOS MÁS VENDIDOS
$productosQuery = mysqli_query($conexion, "
    SELECT pr.prod_nombre, SUM(dv.cantidad) AS total_vendidos
    FROM detalledeventas dv
    INNER JOIN productos pr ON dv.prod_id = pr.prod_id
    GROUP BY pr.prod_id
    ORDER BY total_vendidos DESC
");

// 3. VENTAS POR CLIENTE
$ventasClientesQuery = mysqli_query($conexion, "
    SELECT c.cli_nombre, c.cli_apellido, COUNT(p.pedido_id) AS total_pedidos
    FROM clientes c
    LEFT JOIN pedidos p ON c.cli_id = p.cli_id
    GROUP BY c.cli_id
    ORDER BY total_pedidos DESC
");

// 4. DEVOLUCIONES
$devolucionesQuery = mysqli_query($conexion, "
    SELECT d.dev_id, d.dev_fecha, d.dev_motivo, p.pedido_id 
    FROM devoluciones d
    INNER JOIN pedidos p ON d.pedido_id = p.pedido_id
    ORDER BY d.dev_fecha DESC
");

// 5. INGRESOS POR PROVEEDOR
$ingresosQuery = mysqli_query($conexion, "
    SELECT pr.prov_nombre, pr.prov_apellido, 
           SUM(i.ing_precio) AS total_gastado
    FROM ingresos i
    INNER JOIN proveedores pr ON i.prov_id = pr.prov_id
    GROUP BY pr.prov_id
    ORDER BY total_gastado DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes del Sistema</title>
    <link rel="stylesheet" href="css/reportes.css">
</head>
<body>
<a href="panel.php" class="btnVolver">⬅ Volver</a>

<h2 class="titulo">Reportes del Sistema</h2>

<!-- ===========================
        REPORTE DE VENTAS
=========================== -->
<h3 class="subtitulo">📌 Reporte de Ventas</h3>
<table>
    <tr>
        <th>ID Pedido</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Empleado</th>
        <th>Estado</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($ventasQuery)): ?>
    <tr>
        <td><?= $row['pedido_id'] ?></td>
        <td><?= $row['pedido_fecha'] ?></td>
        <td><?= $row['cli_nombre'] . " " . $row['cli_apellido'] ?></td>
        <td><?= $row['emp_nombre'] . " " . $row['emp_apellido'] ?></td>
        <td><?= $row['pedido_estado'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- ===========================
  PRODUCTOS MÁS VENDIDOS
=========================== -->
<h3 class="subtitulo">📌 Productos más vendidos</h3>
<table>
    <tr>
        <th>Producto</th>
        <th>Cantidad Vendida</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($productosQuery)): ?>
    <tr>
        <td><?= $row['prod_nombre'] ?></td>
        <td><?= $row['total_vendidos'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- ===========================
        VENTAS POR CLIENTE
=========================== -->
<h3 class="subtitulo">📌 Ventas por Cliente</h3>
<table>
    <tr>
        <th>Cliente</th>
        <th>Total de Pedidos</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($ventasClientesQuery)): ?>
    <tr>
        <td><?= $row['cli_nombre'] . " " . $row['cli_apellido'] ?></td>
        <td><?= $row['total_pedidos'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- ===========================
           DEVOLUCIONES
=========================== -->
<h3 class="subtitulo">📌 Devoluciones</h3>
<table>
    <tr>
        <th>ID Devolución</th>
        <th>Fecha</th>
        <th>Motivo</th>
        <th>ID Pedido</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($devolucionesQuery)): ?>
    <tr>
        <td><?= $row['dev_id'] ?></td>
        <td><?= $row['dev_fecha'] ?></td>
        <td><?= $row['dev_motivo'] ?></td>
        <td><?= $row['pedido_id'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- ===========================
        GASTOS POR PROVEEDOR
=========================== -->
<h3 class="subtitulo">📌 Ingresos (Gastos) por Proveedor</h3>
<table>
    <tr>
        <th>Proveedor</th>
        <th>Total Gastado</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($ingresosQuery)): ?>
    <tr>
        <td><?= $row['prov_nombre'] . " " . $row['prov_apellido'] ?></td>
        <td>$<?= number_format($row['total_gastado'], 2) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
