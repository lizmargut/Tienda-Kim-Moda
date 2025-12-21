<?php
require_once "conexion.php";
require_once "carrito.php"; // Incluye el archivo carrito.php

// Verificar si se ha enviado el formulario de finalizar venta
if (isset($_POST['finalizar'])) {
    $cli_id = (int)$_POST['cli_id'];
    $emp_id = (int)$_POST['emp_id'];
    $estado = $conexion->real_escape_string($_POST['estado']);
    $medio_pago = $conexion->real_escape_string($_POST['medio_pago']);

    // Obtener datos del carrito
    $carrito = obtenerDatosCarrito($conexion);
    $cart_items = $carrito['cart_items'];
    $total = round((float)$carrito['total'], 2); // Redondea el total a 2 decimales

    if (empty($cart_items)) {
        echo "<script>alert('El carrito está vacío.'); window.location='ventas.php';</script>";
        exit;
    }
    //
    // Validar pago en efectivo
    if ($medio_pago === 'Efectivo') {
        $pago_con = round((float)$_POST['pago_con'], 2); // Redondea el pago_con a 2 decimales
        if ($pago_con < $total) {
            echo "<script>alert('El pago es insuficiente.'); window.location='ventas.php';</script>";
            exit;
        }
        $vuelto = $pago_con - $total;
    } else {
        $pago_con = 0; // Si no es efectivo, no hay pago_con
        $vuelto = 0; // Si no es efectivo, no hay vuelto
    }

    $cart = $_SESSION['cart'];
    $ids = implode(',', array_map('intval', array_keys($cart)));

    // obtener precios y stocks actuales
    $res = $conexion->query("SELECT prod_id, prod_precio, prod_stock FROM productos WHERE prod_id IN ($ids)");
    $prodInfo = [];
    while ($r = $res->fetch_assoc()) $prodInfo[$r['prod_id']] = $r;

    // begin transaction
    $conexion->begin_transaction();
    try {
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO pedidos (cli_id, emp_id, pedido_fecha, pedido_estado, pedido_medio_pago) VALUES ($cli_id, $emp_id, '$fecha', '$estado', '$medio_pago')";
        if (!$conexion->query($sql)) throw new Exception($conexion->error);
        $pedido_id = $conexion->insert_id;

        foreach ($cart as $pid => $qty) {
            $info = $prodInfo[$pid] ?? null;
            if (!$info) throw new Exception("Producto ID $pid no encontrado.");
            if ($info['prod_stock'] < $qty) throw new Exception("Stock insuficiente para {$info['prod_id']}.");

            $ins = "INSERT INTO detalledeventas (pedido_id, prod_id, cantidad) VALUES ($pedido_id, $pid, $qty)";
            if (!$conexion->query($ins)) throw new Exception($conexion->error);

            $newStock = $info['prod_stock'] - $qty;
            if (!$conexion->query("UPDATE productos SET prod_stock = $newStock WHERE prod_id = $pid")) throw new Exception($conexion->error);
        }

        $conexion->commit();
        unset($_SESSION['cart']);
        $_SESSION['cart'] = [];

        // Mensaje de éxito con vuelto
        $mensaje_vuelto = ($medio_pago === 'Efectivo') ? " y el vuelto es de $" . number_format($vuelto, 2, ',', '.') : "";
        echo "<script>alert('✔ Venta registrada correctamente (Pedido #$pedido_id)$mensaje_vuelto'); window.location='ventas.php';</script>";
        exit;

    } catch (Exception $e) {
        $conexion->rollback();
        $msg = addslashes($e->getMessage());
        echo "<script>alert('❌ Error al finalizar venta: $msg'); window.location='ventas.php';</script>";
        exit;
    }
}
?>