<?php
require_once "conexion.php";

if (!isset($_GET['id']) || !isset($_GET['prod'])) {
    die("Datos incompletos");
}

$img_id = (int) $_GET['id'];
$prod_id = (int) $_GET['prod'];

/* ===============================
   BUSCAR RUTA DE LA IMAGEN
================================ */
$sql = "SELECT img_ruta FROM imagenes WHERE img_id = $img_id";
$res = $conexion->query($sql);

if ($res && $res->num_rows > 0) {
    $img = $res->fetch_assoc();
    $ruta = "img/" . $img['img_ruta'];

    // Eliminar archivo físico
    if (file_exists($ruta)) {
        unlink($ruta);
    }

    // Eliminar registro BD
    $conexion->query("DELETE FROM imagenes WHERE img_id = $img_id");
}

header("Location: cuerpoDetalle.php?id=$prod_id");
exit;
?>