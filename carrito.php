<?php
session_start();
require_once "conexion.php";

// Inicializar carrito
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Agregar producto al carrito
if (isset($_POST['add_to_cart'])) {
    $prod_id = (int)$_POST['prod_id'];
    $cantidad = max(1, (int)$_POST['cantidad']);
    if (isset($_SESSION['cart'][$prod_id])) {
        $_SESSION['cart'][$prod_id] += $cantidad;
    } else {
        $_SESSION['cart'][$prod_id] = $cantidad;
    }
    header("Location: ventas.php"); // Redirige de vuelta a ventas.php
    exit;
}

// Eliminar item del carrito
if (isset($_GET['remove'])) {
    $rid = (int)$_GET['remove'];
    unset($_SESSION['cart'][$rid]);
    header("Location: ventas.php"); // Redirige de vuelta a ventas.php
    exit;
}

// Vaciar carrito
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    $_SESSION['cart'] = [];
    header("Location: ventas.php"); // Redirige de vuelta a ventas.php
    exit;
}

// Obtener datos del carrito para mostrar resumen (función reutilizable)
function obtenerDatosCarrito($conexion) {
    $cart_items = [];
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        $ids = array_keys($_SESSION['cart']);
        $ids_list = implode(',', array_map('intval', $ids));
        $sql2 = "SELECT prod_id, prod_nombre, prod_precio, prod_stock FROM productos WHERE prod_id IN ($ids_list)";
        $r2 = $conexion->query($sql2);
        if ($r2) { // Verifica si la consulta fue exitosa
            while ($row = $r2->fetch_assoc()) {
                $id = $row['prod_id'];
                $row['cantidad'] = $_SESSION['cart'][$id];
                $row['subtotal'] = $row['cantidad'] * $row['prod_precio'];
                $cart_items[$id] = $row;
                $total += $row['subtotal']; // Calcula el total aquí
            }
        } else {
            echo "Error en la consulta: " . $conexion->error;
        }
    }
    return ['cart_items' => $cart_items, 'total' => $total];
}
//
// Procesar la finalización de la venta (mantener en ventas.php o mover a finalizar_venta.php)
?>