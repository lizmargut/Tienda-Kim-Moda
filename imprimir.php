<?php
session_start();
require_once "conexion.php";

// Verificar si se proporciona el ID del pedido
if (!isset($_GET['pedido_id']) || !is_numeric($_GET['pedido_id'])) {
    echo "ID de pedido inválido.";
    exit;
}

$pedido_id = (int)$_GET['pedido_id'];

// Obtener información del pedido gt
$sql_pedido = "
    SELECT ped.pedido_id, ped.pedido_fecha, ped.pedido_estado, ped.pedido_medio_pago,
           c.cli_nombre, c.cli_apellido,
           e.emp_nombre, e.emp_apellido
    FROM pedidos ped
    LEFT JOIN clientes c ON ped.cli_id = c.cli_id
    LEFT JOIN empleados e ON ped.emp_id = e.emp_id
    WHERE ped.pedido_id = $pedido_id
";

$resultado_pedido = $conexion->query($sql_pedido);

if (!$resultado_pedido) {
    echo "Error en la consulta del pedido: " . $conexion->error;
    exit;
}

if ($resultado_pedido->num_rows == 0) {
    echo "Pedido no encontrado.";
    exit;
}

$pedido = $resultado_pedido->fetch_assoc();

// Obtener detalles del pedido
$sql_detalle = "
    SELECT dv.cantidad, p.prod_nombre, p.prod_precio
    FROM detalledeventas dv
    JOIN productos p ON dv.prod_id = p.prod_id
    WHERE dv.pedido_id = $pedido_id
";

$resultado_detalle = $conexion->query($sql_detalle);

if (!$resultado_detalle) {
    echo "Error en la consulta del detalle: " . $conexion->error;
    exit;
}

$detalles = [];
while ($fila = $resultado_detalle->fetch_assoc()) {
    $detalles[] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Imprimir Pedido #<?php echo $pedido['pedido_id']; ?></title>
    <link rel="stylesheet" href="css/imprimir.css">
</head>
<body>
    <div class="ticket">
        <h1>Kim Moda</h1>
        <p>Pedido #<?php echo $pedido['pedido_id']; ?></p>
        <p>Fecha: <?php echo $pedido['pedido_fecha']; ?></p>
        <?php if ($pedido['cli_nombre']): ?>
            <p>Cliente: <?php echo htmlspecialchars($pedido['cli_nombre'] . ' ' . $pedido['cli_apellido']); ?></p>
        <?php else: ?>
            <p>Cliente: Consumidor Final</p>
        <?php endif; ?>
        <p>Vendedor: <?php echo htmlspecialchars($pedido['emp_nombre'] . ' ' . $pedido['emp_apellido']); ?></p>
        <p>Estado: <?php echo htmlspecialchars($pedido['pedido_estado']); ?></p>
        <p>Medio de Pago: <?php echo htmlspecialchars($pedido['pedido_medio_pago']); ?></p>

        <hr>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($detalles as $detalle):
                    $subtotal = $detalle['cantidad'] * $detalle['prod_precio'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detalle['prod_nombre']); ?></td>
                        <td><?php echo $detalle['cantidad']; ?></td>
                        <td>$<?php echo number_format($detalle['prod_precio'], 2, ',', '.'); ?></td>
                        <td>$<?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <p class="total">Total: $<?php echo number_format($total, 2, ',', '.'); ?></p>
    </div>

    <script>
        window.onload = function() {
            window.print();
            //Opcional:  Cerrar la ventana después de imprimir
            //window.onafterprint = function() { window.close(); }
        };
    </script>
</body>
</html>