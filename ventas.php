<?php
session_start();
require_once "conexion.php";
require_once "carrito.php"; // Incluye el archivo carrito.php




if (!isset($_SESSION['emp_id'])) {
    header("Location: login.php");
    exit;
}

$nombre   = $_SESSION['emp_nombre'];
$apellido = $_SESSION['emp_apellido'];
$rol      = $_SESSION['fun_descripcion'];


// Obtener datos del carrito
$carrito = obtenerDatosCarrito($conexion);
$cart_items = $carrito['cart_items'];
$total = $carrito['total'];

// Inicializar variables para el vuelto
$vuelto = 0;
$pago_con = 0;

// ---------------------- CRUD PEDIDOS (editar estado / eliminar) ----------------------
if (isset($_POST['editar_pedido'])) {
    $pid = (int)$_POST['pedido_id'];
    $estado = $conexion->real_escape_string($_POST['pedido_estado']);
    if ($conexion->query("UPDATE pedidos SET pedido_estado = '$estado' WHERE pedido_id = $pid")) {
        echo "<script>alert('✔ Estado actualizado'); window.location='ventas.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar');</script>";
    }
}

if (isset($_GET['delete_pedido'])) {
    $pid = (int)$_GET['delete_pedido'];
    // borrar detalle primero por FK
    if ($conexion->query("DELETE FROM detalledeventas WHERE pedido_id = $pid") &&
        $conexion->query("DELETE FROM devoluciones WHERE pedido_id = $pid") && // Eliminar devoluciones asociadas
        $conexion->query("DELETE FROM pedidos WHERE pedido_id = $pid")) {
        echo "<script>alert('✔ Pedido eliminado'); window.location='ventas.php';</script>";
    } else {
        echo "<script>alert('❌ Error al eliminar pedido');</script>";
    }
}

// ---------------------- consultas principales ----------------------
// productos para mostrar (limitar a 50)
$search = isset($_GET['q']) ? $conexion->real_escape_string($_GET['q']) : '';
$sql = "SELECT p.prod_id, p.prod_nombre, p.prod_precio, p.prod_stock,
               (SELECT img_ruta 
                FROM imagenes 
                WHERE prod_id = p.prod_id 
                LIMIT 1) AS img_ruta,
               c.cat_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.cat_id = c.cat_id
        WHERE p.prod_nombre LIKE '%$search%'
        LIMIT 50";

$res = $conexion->query($sql);

// listar pedidos (últimos 50)
$pedidos = $conexion->query("
    SELECT ped.pedido_id, ped.pedido_fecha, ped.pedido_estado, ped.pedido_medio_pago,
           c.cli_nombre, c.cli_apellido,
           e.emp_nombre, e.emp_apellido
    FROM pedidos ped
    LEFT JOIN clientes c ON ped.cli_id = c.cli_id
    LEFT JOIN empleados e ON ped.emp_id = e.emp_id
    ORDER BY ped.pedido_id DESC
    LIMIT 50
");

if (!$pedidos) {
    echo "Error en la consulta: " . $conexion->error;
    exit; // Detener la ejecución si hay un error
}

// listas para selects en finalizar
$clientes = $conexion->query("SELECT * FROM clientes");
$empleados = $conexion->query("SELECT emp_id, emp_nombre, emp_apellido FROM empleados");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Ventas - Kim Moda (Mixto)</title>
<link rel="stylesheet" href="css/ventas.css">
</head>
<body>
    <a href="panel.php" class="btnVolver">⬅ Volver</a>

<header class="topbar">
    <h1>Kim Moda — Ventas</h1>
    <div class="top-actions">
        <form method="GET" class="searchform"><input type="text" name="q" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($search); ?>"><button class="btn">Buscar</button></form>
        <a href="ventas.php?clear=1" class="btn btn-outline" onclick="return confirm('Vaciar carrito?')">Vaciar carrito</a>
    </div>
</header>

<main class="main-grid">
    <section class="productos-col">
        <h2>Productos</h2>
        <div class="productos-grid">
            <?php while ($p = $res->fetch_assoc()) { ?>
                <div class="card-prod">
                    <div class="img-wrap"><img src="img/<?php echo htmlspecialchars($p['img_ruta'] ?? 'noimg.png'); ?>" alt=""></div>
                    <div class="info">
                        <h3><?php echo htmlspecialchars($p['prod_nombre']); ?></h3>
                        <div class="muted"><?php echo htmlspecialchars($p['cat_nombre'] ?? '-'); ?></div>
                        <div class="price">$<?php echo number_format($p['prod_precio'],2,',','.'); ?></div>
                        <div class="small">Stock: <?php echo (int)$p['prod_stock']; ?></div>

                        <form method="POST" class="addform">
                            <input type="hidden" name="prod_id" value="<?php echo (int)$p['prod_id']; ?>">
                            <input type="number" name="cantidad" value="1" min="1" class="qty">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Agregar</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <aside class="cart-col">
        <h2>Carrito</h2>
        <?php if (empty($cart_items)) { ?>
            <p class="vacio">No hay productos en el carrito.</p>
        <?php } else { ?>
            <div class="cart-list">
                <?php foreach ($cart_items as $it) { ?>
                    <div class="cart-item">
                        <div><strong><?php echo htmlspecialchars($it['prod_nombre']); ?></strong><br><span class="small-muted">x<?php echo (int)$it['cantidad']; ?> — $<?php echo number_format($it['prod_precio'],2,',','.'); ?></span></div>
                        <div class="right">
                            <div class="subtotal">$<?php echo number_format($it['subtotal'],2,',','.'); ?></div>
                            <a href="ventas.php?remove=<?php echo $it['prod_id']; ?>" class="link-del">Eliminar</a>
                        </div>
                    </div>
                <?php } ?>

                <div class="total-row">
                    <div>Total</div>
                    <div class="total-amount">$<?php echo number_format($total,2,',','.'); ?></div>
                </div>

                <details class="finalize">
                    <summary class="btn btn-primary">Finalizar venta</summary>
                    <form method="POST" class="finalize-form" action="finalizarVenta.php">
                        <label>Cliente (opcional)</label>
                        <select name="cli_id">
                            <option value="0">Consumidor final</option>
                            <?php $clientes->data_seek(0); while ($c = $clientes->fetch_assoc()) { echo "<option value=\"{$c['cli_id']}\">{$c['cli_nombre']} {$c['cli_apellido']}</option>"; } ?>
                        </select>

                       

                        <label>Vendedor</label>

                        <input type="hidden" name="emp_id" value="<?= $_SESSION['emp_id']; ?>">

                        <input type="text" class="form-control"
                            value="<?= $_SESSION['emp_nombre'] . ' ' . $_SESSION['emp_apellido']; ?>"
                            readonly>

                        <label>Estado</label>
                        <select name="estado" required>
                            <option value="Entregado">Entregado</option>
                            <option value="En preparación">En preparación</option>
                            <option value="Anulado">Anulado</option>
                        </select>

                        <label>Medio de Pago</label>
                        <select name="medio_pago" required id="medio_pago">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <!-- Agrega más opciones si es necesario -->
                        </select>

                        <!-- Campo para el pago con (solo visible si es efectivo) -->
                        <div id="pago_con_div" style="display: none;">
                            <label>Paga con:</label>
                            <input type="number" name="pago_con" id="pago_con" step="0.01" min="<?php echo $total; ?>">
                        </div>

                        <!-- Mostrar el vuelto -->
                        <?php if ($vuelto > 0): ?>
                            <p>Vuelto: $<?php echo number_format($vuelto, 2, ',', '.'); ?></p>
                        <?php endif; ?>

                        <button type="submit" name="finalizar" class="btn btn-success">Confirmar y Guardar</button>
                    </form>
                </details>

            </div>
        <?php } ?>
    </aside>
</main>

<section class="pedidos-section">
    <h2>Pedidos (últimos)</h2>
    <table class="pedidos-table">
        <thead><tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th><th>Estado</th><th>Medio de Pago</th><th>Acciones</th></tr></thead>
        <tbody>
            <?php
            while ($r = $pedidos->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $r['pedido_id']; ?></td>
                <td><?php echo $r['pedido_fecha']; ?></td>
                <td><?php echo $r['cli_nombre'] ? $r['cli_nombre'].' '.$r['cli_apellido'] : 'Consumidor final'; ?></td>
                <td><?php echo $r['emp_nombre'].' '.$r['emp_apellido']; ?></td>
                <td><?php echo $r['pedido_estado']; ?></td>
                <td><?php echo $r['pedido_medio_pago']; ?></td>
                <td>
                    <button class="btn btn-outline" onclick="openEdit(<?php echo $r['pedido_id'];?>,'<?php echo $r['pedido_estado'];?>')">Editar</button>
                    <a class="btn btn-danger" href="ventas.php?delete_pedido=<?php echo $r['pedido_id'];?>" onclick="return confirm('Eliminar pedido?')">Eliminar</a>
                    <a class="btn btn-success" href="devoluciones.php?pedido_id=<?php echo $r['pedido_id'];?>" target="_blank">Devolucion</a>
                    <a class="btn btn-success" href="imprimir.php?pedido_id=<?php echo $r['pedido_id'];?>" target="_blank">Imprimir</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>

<!-- modal editar pedido (simple) -->
<div id="editModal" class="modal">
    <div class="modal-content small">
        <h3>Editar Estado de Pedido</h3>
        <form method="POST">
            <input type="hidden" name="pedido_id" id="edit_pid">
            <label>Estado</label>
            <select name="pedido_estado" id="edit_estado">
                <option>Entregado</option>
                <option>En preparación</option>
                <option>Anulado</option>
            </select>
            <div style="margin-top:12px;">
                <button type="submit" name="editar_pedido" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-outline" onclick="closeEdit()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id, estado) {
    document.getElementById('edit_pid').value = id;
    document.getElementById('edit_estado').value = estado;
    document.getElementById('editModal').style.display = 'block';
}
function closeEdit() { document.getElementById('editModal').style.display = 'none'; }

// Mostrar/Ocultar campo "Paga con" según el medio de pago
document.getElementById('medio_pago').addEventListener('change', function() {
    var pagoConDiv = document.getElementById('pago_con_div');
    if (this.value === 'Efectivo') {
        pagoConDiv.style.display = 'block';
    } else {
        pagoConDiv.style.display = 'none';
    }
});
</script>

</body>
</html>