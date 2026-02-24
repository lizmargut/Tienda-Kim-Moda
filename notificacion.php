<?php
include("conexion.php");

// ==============================
// NOTIFICACIONES DEL SISTEMA
// ==============================

// 1. Nuevos pedidos (últimos 7 días)
$pedidos = mysqli_query($conexion, "
    SELECT p.pedido_id, p.pedido_fecha, c.cli_nombre, c.cli_apellido
    FROM pedidos p
    INNER JOIN clientes c ON p.cli_id = c.cli_id
    WHERE p.pedido_fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ORDER BY p.pedido_fecha DESC
");

// 2. Nuevos clientes (últimos 7 días)
$clientes = mysqli_query($conexion, "
    SELECT * FROM clientes
    WHERE cli_id IN (
        SELECT cli_id FROM pedidos WHERE pedido_fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    )
");

// 3. Productos con poco stock (menos de 5 unidades)
$stockBajo = mysqli_query($conexion, "
    SELECT * FROM productos
    WHERE prod_stock < 5
    ORDER BY prod_stock ASC
");

// 4. Últimas devoluciones
$devoluciones = mysqli_query($conexion, "
    SELECT d.dev_id, d.dev_motivo, d.dev_fecha, p.pedido_id
    FROM devoluciones d
    INNER JOIN pedidos p ON d.pedido_id = p.pedido_id
    ORDER BY d.dev_fecha DESC
    LIMIT 5
");

// 5. Últimos ingresos de proveedores
// $ingresos = mysqli_query($conexion, "
//     SELECT i.ing_fecha, i.ing_precio, pr.prov_nombre, pr.prov_apellido
//     FROM ingresos i
//     INNER JOIN proveedores pr ON i.prov_id = pr.prov_id
//     ORDER BY i.ing_fecha DESC
//     LIMIT 5
// ");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="css/notificaciones.css">
</head>
<body>
<a href="panel.php" class="btnVolver">⬅ Volver</a>

<h2 class="titulo">🔔 Notificaciones del Sistema</h2>

<div class="contenedor">

    <!-- Notificaciones de Pedidos -->
    <div class="caja">
        <h3>📦 Nuevos Pedidos</h3>
        <?php if (mysqli_num_rows($pedidos) == 0): ?>
            <p class="vacio">No hay nuevos pedidos.</p>
        <?php else: ?>
            <?php while ($p = mysqli_fetch_assoc($pedidos)): ?>
                <div class="item">
                    <strong>Pedido #<?= $p['pedido_id'] ?></strong><br>
                    Cliente: <?= $p['cli_nombre'] . " " . $p['cli_apellido'] ?><br>
                    Fecha: <?= $p['pedido_fecha'] ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Nuevos Clientes -->
    <div class="caja">
        <h3>🧍 Nuevos Clientes</h3>
        <?php if (mysqli_num_rows($clientes) == 0): ?>
            <p class="vacio">No hay nuevos clientes.</p>
        <?php else: ?>
            <?php while ($c = mysqli_fetch_assoc($clientes)): ?>
                <div class="item">
                    <strong><?= $c['cli_nombre'] . " " . $c['cli_apellido'] ?></strong><br>
                    Tel: <?= $c['cli_tel'] ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Stock Bajo -->
    <div class="caja alerta">
        <h3>⚠️ Productos con Bajo Stock</h3>
        <?php if (mysqli_num_rows($stockBajo) == 0): ?>
            <p class="vacio">No hay productos con bajo stock.</p>
        <?php else: ?>
            <?php while ($s = mysqli_fetch_assoc($stockBajo)): ?>
                <div class="item">
                    <strong><?= $s['prod_nombre'] ?></strong><br>
                    Stock: <?= $s['prod_stock'] ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Devoluciones -->
    <div class="caja">
        <h3>↩️ Últimas Devoluciones</h3>
        <?php while ($d = mysqli_fetch_assoc($devoluciones)): ?>
            <div class="item">
                <strong>Devolución #<?= $d['dev_id'] ?></strong><br>
                Motivo: <?= $d['dev_motivo'] ?><br>
                Fecha: <?= $d['dev_fecha'] ?>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Ingresos de Proveedores -->
    

</div>

</body>
</html>
