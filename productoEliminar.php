<?php
require_once "conexion.php";

if (!isset($_GET['id'])) {
    die("Error: ID no enviado.");
}

$id = $_GET['id'];

// 1) eliminar dependencias
$conexion->query("DELETE FROM detalledeventas WHERE prod_id = $id");
$conexion->query("DELETE FROM ingresos WHERE prod_id = $id");

// 2) eliminar producto
$query = "DELETE FROM productos WHERE prod_id = $id";

if ($conexion->query($query)) {
    echo "<script>alert('Producto eliminado correctamente'); window.location='cuerpo.php';</script>";
} else {
    echo "<script>alert('Error al eliminar el producto'); window.history.back();</script>";
}
?>
