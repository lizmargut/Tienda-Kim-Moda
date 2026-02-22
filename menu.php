<?php
$rol = "administrador"; // Simulación de rol
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">

        <!-- Marca -->
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-shop"></i> Mi Negocio
        </a>

        <!-- Botón hamburguesa (celular) -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
                aria-controls="navbarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Visible para todos -->
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">
                        <i class="bi bi-cash-coin"></i> Ventas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="clientes.php">
                        <i class="bi bi-person-fill"></i> Clientes
                    </a>
                </li>

                <!-- /* <?php if ($rol == "administrador") { ?>

                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#">
                            <i class="bi bi-bar-chart-line-fill"></i> Ventas (Admin)
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#">
                            <i class="bi bi-people-fill"></i> Clientes (Admin)
                        </a>
                    </li>

                <?php } ?> -->

                <li class="nav-item">
                    <a class="nav-link" href="proveedores.php">
                        <i class="bi bi-truck"></i> Proveedores
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="reportes.php">
                        <i class="bi bi-file-earmark-text"></i> Reportes
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="notificacion.php">
                        <i class="bi bi-bell-fill"></i> Notificaciones
                    </a>
                </li>

            </ul>

            <!-- Botón cerrar sesión a la derecha -->
            <a href="logout.php" class="btn btn-outline-light">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>

        </div>
    </div>
</nav>

<!-- Bootstrap JS (OBLIGATORIO para que funcione el menú hamburguesa) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
