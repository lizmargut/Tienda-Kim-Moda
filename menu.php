<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación</title>
    <!-- Enlace a Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
   
</head>
<body>
    <nav>
        <!-- Menú visible para todos -->
        <a href="index.php"><i class="bi bi-cash-coin"></i> Ventas</a>
        <a href="productos.php"><i class="bi bi-person-fill"></i> Clientes</a>

        <?php 
        if ($rol == "administrador") {
        ?>
            <a href="#"><i class="bi bi-bar-chart-line-fill"></i> Ventas (Admin)</a>
            <a href="#"><i class="bi bi-people-fill"></i> Clientes (Admin)</a>
        <?php
        }
        ?>

        <a href="#"><i class="bi bi-truck"></i> Proveedores</a>
        <a href="login.php"><i class="bi bi-file-earmark-text"></i> Reportes</a>
        <a href="#"><i class="bi bi-bell-fill"></i> Notificaciones</a>
    </nav>
</body>
</html>
