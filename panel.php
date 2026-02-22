<?php
session_start();

if (!isset($_SESSION['emp_id'])) {
    header("Location: login.php");
    exit;
}

// Datos del usuario logueado
$usuario = $_SESSION['emp_nombre'] . " " . $_SESSION['emp_apellido'];
$rol = $_SESSION['fun_descripcion']; // Ahora es texto, no número

// Si es Administrador, redirigir
if ($rol == "Administrador") {
    header("Location: productosAdministrar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="css/panel.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="container">

    <h1>Bienvenido, <?= $usuario ?></h1>
    <p class="sub">Rol: <?= $rol ?></p>
    <p class="sub">KIM MODA</p>

    <div class="cards">

        <!-- OPCIONES SOLO PARA VENDEDORES -->
        <?php if ($rol == "Vendedor") { ?>

            <a class="card" href="ventas.php">
                <i class="bi bi-cart-check-fill"></i>
                <h3>Ventas</h3>
                <p>Registrar ventas diarias</p>
            </a>

            <a class="card" href="clientes.php">
                <i class="bi bi-people-fill"></i>
                <h3>Clientes</h3>
                <p>Consulta y gestión de clientes</p>
            </a>

            <a class="card" href="notificacion.php">
                <i class="bi bi-bell-fill"></i>
                <h3>Notificaciones</h3>
                <p>Mensajes y avisos del sistema</p>
            </a>

        <?php } ?>

    </div>

    <a href="logout.php" class="logout">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </a>

</div>

</body>
</html>